<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Finance\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function __invoke(Payroll $payroll)//generateReport(Payroll $payroll)
    {
        // Get data
        $id = request()->route('order');
        $payroll = Payroll::with([
            'payrollTransactions.companyEmployee.user',
            'payrollTransactions.companyEmployee.position',
            'payrollTransactions.companyEmployee.department',
            'payrollTransactions.companyEmployee.salary_grade',
            'payrollTransactions.companyEmployee.currency',
            'payrollTransactions.companyEmployee.employeeAllowances.allowance',
            'employeedeductions.deduction'
        ])->findOrFail($id);
        //dd($payroll);

        $pdf = PDF::loadView('documents.payroll', compact('payroll'));
        $pdf = PDF::loadView('documents.payslip-zut', compact('payroll'));
       // return $pdf->stream("payroll-{$payroll->month}.pdf");
        return $pdf->stream("payslip-{$payroll->month}.pdf");
       //return $pdf->download("payroll-{$payroll->month}.pdf");
    }
    public function __invokes(Payroll $order)
    {
        $payrolls = Payroll::with(['payrollTransactions' => function ($query) use ($order) {
            $query->select('id', 'payroll_id', 'company_employee_id', 'gross_salary', 'allowances', 'deductions', 'net_salary', 'pay_date');
        }])->get();

        //dd($payrolls);
        // Generate the PDF
        $pdf = PDF::loadView('documents.payroll', ['payrolls' => $payrolls]);

        // Return the PDF as a downloadable response
        return $pdf->download('payroll_report.pdf');
//        dd($order);
//        return Pdf::loadView('pdf', ['record' => $order])
//            ->download($order->id. '.pdf');
    }

    public function __invoki(Payroll $order)
    {
        $payroll = Payroll::with([
            'company',
            'payslips.employee' => function($query) {
                $query->with([
                    'user',
                    'position',
                    'department',
                    'employmentType',
                    'paymentMethod',
                    'employeeBankAccount',
                    'employeeMobileMoney',
                    'deductionTransactions.deduction',
                    'allowances',
                    'leaveBalances.leaveType',
                    'salaryGrade'
                ]);
            }
        ])->findOrFail($payrollId);
    }
}
