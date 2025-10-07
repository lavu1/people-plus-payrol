<?php

namespace App\Observers\Payroll;

use App\Models\Academics\Grade;
use App\Models\Allowance\Allowance;
use App\Models\Allowance\EmployeeAllowance;
use App\Models\Company\Company;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Deduction;
use App\Models\Finance\DeductionTransaction;
use App\Models\Finance\Gratuity;
use App\Models\Finance\GratuityTransactions;
use App\Models\Finance\OverTimeClaim;
use App\Models\Finance\Payroll;
use App\Models\Finance\Saving;
use App\Models\Finance\SavingsApplication;
use App\Models\Finance\SavingsTransaction;
use App\Models\Leave\LeaveSale;
use App\Models\Payroll\PayrollTransactions;
use App\Models\User;
use function Symfony\Component\String\s;

class PayrollObserver
{
    /**
     * Handle the Payroll "created" event.
     */
//    public function creating(Payroll $payroll): void
//    {
//        $this->calculateAllowances($payroll);
//        $this->calculateDeductions($payroll);
//    }

    public function created(Payroll $payroll): void
    {
        $this->calculateAllowances($payroll);
        $this->calculateDeductions($payroll);
    }

    /**
     * Handle the Payroll "updated" event.
     */
    public function updated(Payroll $payroll): void
    {

        $company = Company::with('companyBranch.departments')->find($payroll->company_id);

        // Get all department IDs belonging to the company's branches
        $departmentIds = $company->companyBranch->flatMap(function ($branch) {
            return $branch->departments->pluck('id');
        })->toArray();

        // Fetch all employees for the company based on department_id
        $employees = CompanyEmployee::whereIn('department_id', $departmentIds)->get();

        foreach ($employees as $employee) {
            $allowances = $this->calculatePayroll($employee->id, $payroll->id, $employee);
            $deductions = $this->calculatePayrollDeductions($employee->id, $payroll->id, $employee); //dd($deductions['total_deductions']);
            if ($payroll->processed == 1) {
                PayrollTransactions::updateOrCreate(//updateOrCreate create
                    [
                        'payroll_id' => $payroll->id,
                        'company_employee_id' => $employee->id,
                    ],
                    [
                        'gross_salary' => $allowances['gross_pay'],
                        'allowances' => $allowances['total_allowances'],
                        'deductions' => $deductions['total_deductions'],
                        'pay_date' => $payroll->updated_at,
                        'net_salary' => ($allowances['gross_pay'] - $deductions['total_deductions']),
                    ]
                );
            }
        }
        if ($payroll->processed == 0) {
            PayrollTransactions::where('payroll_id', $payroll->id)->delete();
        }

    }
    public function deleting(Payroll $payroll): void
    {
        EmployeeAllowance::where('payroll_id', $payroll->id)->delete();
        DeductionTransaction::where('payroll_id', $payroll->id)->delete();
        PayrollTransactions::where('payroll_id', $payroll->id)->delete();
        GratuityTransactions::where('payroll_id', $payroll->id)->delete();
        LeaveSale::where('payroll_id', $payroll->id)->delete();
        OverTimeClaim::where('payroll_id', $payroll->id)->delete();
    }

    /**
     * Handle the Payroll "deleted" event.
     */
    public function deleted(Payroll $payroll): void
    {
//        EmployeeAllowance::where('payroll_id', $payroll->id)->delete();
//        DeductionTransaction::where('payroll_id', $payroll->id)->delete();
//        PayrollTransactions::where('payroll_id', $payroll->id)->delete();
//        GratuityTransactions::where('payroll_id', $payroll->id)->delete();
    }

    /**
     * Handle the Payroll "restored" event.
     */
    public function restored(Payroll $payroll): void
    {
        //
    }

    /**
     * Handle the Payroll "force deleted" event.
     */
    public function forceDeleted(Payroll $payroll): void
    {
        //
    }

    public function calculateAllowances($payroll)
    {
        // Fetch the company with its branches and departments
        $company = Company::with('companyBranch.departments')->find($payroll->company_id);

        // Get all department IDs belonging to the company's branches
        $departmentIds = $company->companyBranch->flatMap(function ($branch) {
            return $branch->departments->pluck('id');
        })->toArray();

        // Fetch all employees for the company based on department_id
        $employees = CompanyEmployee::whereIn('department_id', $departmentIds)->get();
//dd($employees);
        foreach ($employees as $employee) {
            // Get all allowances for the employee's position
            $allowances = Allowance::where('position_id', $employee->position_id)
                ->where('company_id', $payroll->company_id)
                ->get();

            foreach ($allowances as $allowance) {
                // Create or update the employee allowance record
                EmployeeAllowance::create(//updateOrCreate
                    [
                        'payroll_id' => $payroll->id,
                        'company_employee_id' => $employee->id,
                        'allowances_id' => $allowance->id,
                    ]
                );
            }
        }
    }

    public function calculateDeductions($payroll)
    {
        // Fetch the payroll details
        // $payroll = Payroll::findOrFail($payrollId);
        $companyId = $payroll->company_id;

        // Fetch the company with its branches and departments
        $company = Company::with('companyBranch.departments')->find($companyId);


        // Get all department IDs belonging to the company's branches
        $departmentIds = $company->companyBranch->flatMap(function ($branch) {
            return $branch->departments->pluck('id');
        })->toArray();

        // Fetch all employees for the company based on department_id
        $employees = CompanyEmployee::whereIn('department_id', $departmentIds)->get();

        foreach ($employees as $employee) {
            // Fetch all deductions for the company
            $deductions = Deduction::where('position_id', $employee->position_id)
                ->where('company_id', $payroll->company_id)
                ->get();


            foreach ($deductions as $deduction) {
                if ($deduction->d_type == 'fixed') {
                    // If the deduction is a fixed amount
                    $amount = $deduction->value;
                } else {
                    // If the deduction is a percentage of the salary
                    $amount = $employee->salary * ($deduction->value / 100);
                }

                // Create or update the employee allowance record
                DeductionTransaction::updateOrCreate([
                    'deduction_id' => $deduction->id,
                    'company_employee_id' => $employee->id,
                    'payroll_id' => $payroll->id],
                    [
                    'amount' => $amount,
                    'transaction_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function calculatePayroll(int $employeeId, int $payrollId, $employee): array
    {
        // Get all allowances for the employee and payroll
        $allowances = EmployeeAllowance::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->with('allowance')
            ->get();

        // Calculate total allowances
        $totalAllowances = $allowances->sum(function ($employeeAllowance) use ($employee) {
            // Access the related allowance_name model
            $allowance = $employeeAllowance->allowance;

            // Check if the allowance exists
            if ($allowance) {
                if ($allowance->allowance_type == 'fixed') {
                    return $allowance->value; // Fixed amount
                } elseif ($allowance->allowance_type == 'percentage') {
                    return ($allowance->value / 100) * $employee->salary; // Percentage of salary
                }
            }

            return 0; // Default to 0 if no allowance or invalid type
        });

        //calculate leave sales
        $leaveSaleTotalAmount = LeaveSale::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->sum('sale_amount') ?? 0;
        LeaveSale::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->update(['status' => 'Processed']);
        //calculate the over time
        $OverTimeTotalAmount = OverTimeClaim::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->sum('computed_cost') ?? 0;
        OverTimeClaim::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->update(['status' => 'Processed']);
        // Calculate gross pay
        $grossPay = $employee->salary + $totalAllowances + $leaveSaleTotalAmount + $OverTimeTotalAmount;

        return [
            'employee_id' => $employeeId,
            'payroll_id' => $payrollId,
            'basic_salary' => $employee->salary,
            'total_allowances' => $totalAllowances,
            'gross_pay' => $grossPay,
        ];
    }

    public function calculatePayrollDeductions(int $employeeId, int $payrollId, $employee): array
    {
        // Get all deduction transactions for the employee and payroll
        $deductionTransactions = DeductionTransaction::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->with('deduction')
            ->get();

        // Calculate total deductions
        $totalDeductions = $deductionTransactions->sum(function ($transaction) use ($employee) {
            $deduction = $transaction->deduction;

            if ($deduction->is_fixed) {
                return $deduction->amount;
            } else {
                // If deduction is a percentage, calculate based on employee's salary
                return ($deduction->percentage / 100) * $employee->salary;
            }
        });


        return [
            'employee_id' => $employeeId,
            'payroll_id' => $payrollId,
            'total_deductions' => $totalDeductions + $this->calculateGratuity($employeeId, $payrollId, $employee) + $this->calculateMonthsaving($employeeId, $payrollId, $employee),
        ];
    }

    private function calculateGratuity(int $employeeId, int $payrollId, $employee)
    {
        $gratuity = Gratuity::where('company_employee_id', $employeeId)
            ->get();

        // Calculate total deductions
        $totalGratuityAmount = $gratuity->sum(function ($transaction) use ($payrollId, $employeeId, $employee) {
            $amount = $transaction->g_type == 'fixed'
                ? $transaction->value
                : ($transaction->value / 100) * $employee->salary;
            GratuityTransactions::updateOrCreate([
                'payroll_id' => $payrollId,
                'gratuity_id' => $transaction->id],[
                'amount' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if ($transaction->g_type == 'fixed') {
                return $transaction->value;
            } else {
                // If deduction is a percentage, calculate based on employee's salary
                return ($transaction->value / 100) * $employee->salary;
            }
        });
        return $totalGratuityAmount;
    }

    private function calculateMonthsaving(int $employeeId, int $payrollId, $employee)
    {

        $savingsAps = SavingsApplication::where('status', 1)->where('company_employee_id', $employeeId)->get();
        // Calculate total deductions
        $totalSavingsAmount = $savingsAps->sum(function ($transaction) use ($employeeId, $payrollId, $employee) {
            $saving = Saving::where('company_employee_id', $employeeId)->first();

            $amount = $transaction->s_type == 'fixed'
                ? $transaction->value
                : ($transaction->value / 100) * $employee->salary;
            if (empty($savings)) {
                $savings = Saving::updateOrCreate([
                    'company_employee_id' => $employeeId],
                    [
                    'total_savings' => $amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            } else {
                $savings->total_savings = ($savings->total_savings + $amount);
                $savings->save();

            }
            SavingsTransaction::updateOrCreate([
                'savings_id' => $savings->id,
                'transaction_type' => 'Deposit',
                'payroll_id' => $payrollId,
                ],[
                'amount' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if ($transaction->g_type == 'fixed') {
                return $transaction->value;
            } else {
                // If deduction is a percentage, calculate based on employee's salary
                return ($transaction->value / 100) * $employee->salary;
            }
        });

        return $totalSavingsAmount;
    }
}
