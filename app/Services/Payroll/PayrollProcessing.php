<?php

namespace App\Services\Payroll;

use App\Models\Allowance\EmployeeAllowance;
use App\Models\Finance\DeductionTransaction;
use App\Models\Finance\OverTimeConfig;
use App\Models\Finance\OverTimeRequest;
use Illuminate\Support\Facades\DB;
class PayrollProcessing
{


    function calculateTaxableAllowances($companyId, $payrollId, $employeeId, $basicSalary)
    {
        $allowances = EmployeeAllowance::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->whereHas('allowance', function ($query) use ($companyId) {
                $query->where('company_id', $companyId)
                    ->where('is_taxable', true); // Only taxable allowances
            })
            ->with('allowance')
            ->get();

        $totalTaxable = 0;

        foreach ($allowances as $employeeAllowance) {
            $allowance = $employeeAllowance->allowance;

            if ($allowance->allowance_type === 'fixed') {
                $totalTaxable += $allowance->value;
            } elseif ($allowance->allowance_type === 'percentage') {
                $totalTaxable += ($allowance->value / 100) * $basicSalary;
            }
        }

        return $totalTaxable;
    }

    function calculateNonTaxableAllowances($companyId, $payrollId, $employeeId, $basicSalary)
    {
        $allowances = EmployeeAllowance::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->whereHas('allowance', function ($query) use ($companyId) {
                $query->where('company_id', $companyId)
                    ->where('is_taxable', false); // Only non-taxable allowances
            })
            ->with('allowance')
            ->get();

        $totalNonTaxable = 0;

        foreach ($allowances as $employeeAllowance) {
            $allowance = $employeeAllowance->allowance;

            if ($allowance->allowance_type === 'fixed') {
                $totalNonTaxable += $allowance->value;
            } elseif ($allowance->allowance_type === 'percentage') {
                $totalNonTaxable += ($allowance->value / 100) * $basicSalary;
            }
        }

        return $totalNonTaxable;
    }
    function calculateTotalDeduction($companyId, $payrollId, $employeeId, $basicSalary)
    {
        // Get the deductions for the employee
        $deductions = DeductionTransaction::where('company_employee_id', $employeeId)
            ->where('payroll_id', $payrollId)
            ->whereHas('deduction', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->with('deduction')
            ->get();

        $totalDeduction = 0;

        foreach ($deductions as $deductionTransaction) {
            $deduction = $deductionTransaction->deduction;

            if ($deduction->is_fixed) {
                // Fixed deduction: Use the fixed amount
                $totalDeduction += $deduction->amount;
            } else {
                // Percentage-based deduction: Calculate percentage of the basic salary
                $totalDeduction += ($deduction->percentage / 100) * $basicSalary;
            }
        }

        return $totalDeduction;
    }
    function calculateOvertimeAmount($overTimeType, $requestedHours, $basicSalary, $config, $isTaxable = false)
    {
        // Check overtime type in configuration
        if ($config->calculation_rate === 'percentage') {
            $hourlyRate = ($config->hourly_rate / 100) * ($basicSalary / 208); // Assuming 208 hours in a month
        } else {
            $hourlyRate = $config->hourly_rate;
        }

        $amount = $requestedHours * $hourlyRate;

        return [
            'amount' => $amount,
            'is_taxable' => $isTaxable,
        ];
    }
    function calculateTaxableOvertime($overTimeRequests, $basicSalary)
    {
        $totalTaxable = 0;

        foreach ($overTimeRequests as $request) {
            if ($request->is_taxable) {
                $config = $request->overTimeConfig;
                $result = $this->calculateOvertimeAmount($request->over_time_type, $request->requested_hours, $basicSalary, $config, true);
                $totalTaxable += $result['amount'];
            }
        }

        return $totalTaxable;
    }
    function calculateNonTaxableOvertime($overTimeRequests, $basicSalary)
    {
        $totalNonTaxable = 0;

        foreach ($overTimeRequests as $request) {
            if (!$request->is_taxable) {
                $config = $request->overTimeConfig;
                $result = $this->calculateOvertimeAmount($request->over_time_type, $request->requested_hours, $basicSalary, $config, false);
                $totalNonTaxable += $result['amount'];
            }
        }

        return $totalNonTaxable;
    }
    function createOverTimeRequest($data)
    {
        $request = OverTimeRequest::create([
            'over_time_type' => $data['over_time_type'],
            'requested_hours' => $data['requested_hours'],
            'justification' => $data['justification'],
            'dates_requested' => $data['dates_requested'],
            'computed_cost' => 0, // Initial cost
            'status' => 'Pending',
            'company_employee_id' => $data['employee_id'],
            'supervisor_triggered' => $data['supervisor_triggered'],
        ]);

        // Fetch configuration
        $config = OverTimeConfig::where('over_time_type', $request->over_time_type)
            ->where('status', 'Active')
            ->first();

        if ($config) {
            // Calculate cost
            $request->computed_cost = $this->calculateOvertimeAmount(
                $request->over_time_type,
                $request->requested_hours,
                $data['basic_salary'],
                $config
            )['amount'];
            $request->save();
        }

        return $request;
    }




}
