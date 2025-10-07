<?php

namespace App\Filament\Resources\Payroll\PayrollTransactionsResource\Pages;

use App\Filament\Resources\Payroll\PayrollTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayrollTransactions extends ListRecords
{
    protected static string $resource = PayrollTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
