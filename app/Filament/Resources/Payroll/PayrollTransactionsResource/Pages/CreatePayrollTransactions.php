<?php

namespace App\Filament\Resources\Payroll\PayrollTransactionsResource\Pages;

use App\Filament\Resources\Payroll\PayrollTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayrollTransactions extends CreateRecord
{
    protected static string $resource = PayrollTransactionsResource::class;
}
