<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Finance\Payroll;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generatePayrollUBA()
    {
        ini_set('max_execution_time', 300000000);
        $id = request()->route('order');
        $payroll = Payroll::with([
            'company',
            'payrollTransactions.companyEmployee.user',
            'payrollTransactions.companyEmployee.bank_account',
            'payrollTransactions.companyEmployee.position',
            'payrollTransactions.companyEmployee.department',
            'payrollTransactions.companyEmployee.salary_grade',
            'payrollTransactions.companyEmployee.currency',
            'payrollTransactions.companyEmployee.employeeAllowances.allowance',
            'employeedeductions.deduction'
        ])->findOrFail($id);
        $csvContent = "";
        $total = 0;
            foreach ($payroll->payrollTransactions as $item) {
                        $name = $item->companyEmployee->user->name;
                        $company = $payroll->company->company_name;
                        $netpay = $item->net_salary;
                        $accountNumber = $item->companyEmployee->bank_account->bank_account_number??'3454645';
                        $sort_code = $item->companyEmployee->bank_account->sort_code??'464654';
                        $value_state = 'C';
                        $csvContent .= "$name,$accountNumber,$netpay,$company,$sort_code,$value_state\n";
                $total = $total+$netpay;
            }
        $csvContent .= "The first,48969407,$total,Alphil solutions,KJDBLKJL,D\n";
        $filename = 'UBA-payroll-export-'.now().'-.csv';
        file_put_contents($filename, $csvContent);

        // Force download the CSV file
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filename);
        unlink($filename); // Delete the temporary file
        exit();
    }
    public function generatePayrollZanaco()
    {
        ini_set('max_execution_time', 300000000);
        $id = request()->route('order');
        $payroll = Payroll::with([
            'company',
            'payrollTransactions.companyEmployee.user',
            'payrollTransactions.companyEmployee.bank_account',
            'payrollTransactions.companyEmployee.position',
            'payrollTransactions.companyEmployee.department',
            'payrollTransactions.companyEmployee.salary_grade',
            'payrollTransactions.companyEmployee.currency',
            'payrollTransactions.companyEmployee.employeeAllowances.allowance',
            'employeedeductions.deduction'
        ])->findOrFail($id);
        $csvContent = "";
        $total = 0;
        $company = $payroll->company->company_name;
        $csvContent .= ",,$company,,,\n\n";
        $csvContent .= ",Bank Name : ,Zanaco Business Center,,,\n";
        $csvContent .= "Emp ID,Surname,Firstname,Bank Account No,Sort Code,Amount (ZMW)\n";

        foreach ($payroll->payrollTransactions as $item) {
            $name = $item->companyEmployee->user->name;
            $netpay = $item->net_salary;
            $accountNumber = $item->companyEmployee->bank_account->bank_account_number??'3454645';
            $sort_code = $item->companyEmployee->bank_account->sort_code??'464654';
            $emp_num = rand(100,900);
            $csvContent .= "$emp_num,$name,$name,$accountNumber,$sort_code,$netpay,$name\n";
            $total = $total+$netpay;
        }
        $filename = 'Zanaco-payroll-export-'.now().'.csv';
        file_put_contents($filename, $csvContent);

        // Force download the CSV file
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filename);
        unlink($filename); // Delete the temporary file
        exit();
    }
}
