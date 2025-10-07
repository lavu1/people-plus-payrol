<?php

namespace App\Filament\Resources\Payroll\PayrollTransactionsResource\Pages;

use App\Filament\Resources\Payroll\PayrollTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayrollTransactions extends EditRecord
{
    protected static string $resource = PayrollTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
