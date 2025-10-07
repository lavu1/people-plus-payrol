<?php

namespace App\Filament\Resources\Payroll\GratuityTransactionsResource\Pages;

use App\Filament\Resources\Payroll\GratuityTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGratuityTransactions extends EditRecord
{
    protected static string $resource = GratuityTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
