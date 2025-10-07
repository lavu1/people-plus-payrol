<?php

namespace App\Filament\Resources\GratuityResource\Widgets;

use App\Models\Payroll\PayrollTransactions;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class UserDataChart extends ChartWidget
{
    protected static ?string $heading = 'User Payroll Overview'; // Chart title

    protected function getData(): array
    {
        // Get the authenticated user's ID (or pass it dynamically)
        $userId = auth()->id();

        // Fetch payroll data for the user
        $payrollData = User::get();

        // Prepare data for the chart
        $labels = [];
        $grossSalary = [];
        $allowances = [];
        $deductions = [];
        $netSalary = [];

        foreach ($payrollData as $transaction) {
            $labels[] = $transaction->gender; // Assuming you have a 'month' column
            $grossSalary[] = $transaction->email;
            $allowances[] = $transaction->marital_status;
        }

        return [
            'labels' => $labels, // X-axis labels (e.g., months)
            'datasets' => [
                [
                    'label' => 'By Email',
                    'data' => $grossSalary,
                    'backgroundColor' => '#4CAF50', // Green
                ],
                [
                    'label' => 'Marital status',
                    'data' => $allowances,
                    'backgroundColor' => '#2196F3', // Blue
                ]
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
