<?php

namespace App\Filament\Resources\CompanyEmployeeResource\Widgets\Stats;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Payroll;
use App\Models\Payroll\PayrollTransactions;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Employees', CompanyEmployee::count())
                ->description('Total number of Employees')
                ->color('success'),
            Stat::make('Gross salary', PayrollTransactions::avg('gross_salary'))
                ->description('Average amount per sale')
                ->color('warning'),
            Stat::make('Total Allowances', PayrollTransactions::sum('allowances'))
                ->description('Total Allowances')
                ->color('primary'),
            Stat::make('Total Deductions', PayrollTransactions::sum('deductions'))
                ->description('Total deductions')
                ->color('primary'),
            Stat::make('All Net Salary', PayrollTransactions::sum('net_salary'))
                ->description('Total Net Salary')
                ->color('primary'),
            Stat::make('All Users', User::count())
                ->description('All Users')
                ->color('primary'),
        ];
    }
}
