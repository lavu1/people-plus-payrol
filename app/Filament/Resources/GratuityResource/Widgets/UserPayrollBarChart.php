<?php

namespace App\Filament\Resources\GratuityResource\Widgets;

use App\Models\Payroll\PayrollTransactions;
use Filament\Widgets\ChartWidget;

class UserPayrollBarChart extends ChartWidget
{
    protected static ?string $heading = 'User Payroll Overview'; // Chart title

    protected function getData(): array
    {
        // Get the authenticated user's ID (or pass it dynamically)
        $userId = auth()->id();

        // Fetch payroll data for the user
        $payrollData = PayrollTransactions::get();

        // Prepare data for the chart
        $labels = [];
        $grossSalary = [];
        $allowances = [];
        $deductions = [];
        $netSalary = [];

        foreach ($payrollData as $transaction) {
            $labels[] = $transaction->month; // Assuming you have a 'month' column
            $grossSalary[] = $transaction->gross_salary;
            $allowances[] = $transaction->allowances;
            $deductions[] = $transaction->deductions;
            $netSalary[] = $transaction->net_salary;
        }

        return [
            'labels' => $labels, // X-axis labels (e.g., months)
            'datasets' => [
                [
                    'label' => 'Gross Salary',
                    'data' => $grossSalary,
                    'backgroundColor' => '#4CAF50', // Green
                ],
                [
                    'label' => 'Allowances',
                    'data' => $allowances,
                    'backgroundColor' => '#2196F3', // Blue
                ],
                [
                    'label' => 'Deductions',
                    'data' => $deductions,
                    'backgroundColor' => '#F44336', // Red
                ],
                [
                    'label' => 'Net Salary',
                    'data' => $netSalary,
                    'backgroundColor' => '#FFC107', // Yellow
                ],
            ],
        ];
    }
//    protected function getData(): array
//    {
//        return [
//            //
//        ];
//    }
//
    protected function getType(): string
    {
        return 'bar';
    }
}
