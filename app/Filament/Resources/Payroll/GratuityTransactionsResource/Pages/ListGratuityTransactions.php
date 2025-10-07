<?php

namespace App\Filament\Resources\Payroll\GratuityTransactionsResource\Pages;

use App\Filament\Resources\Payroll\GratuityTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGratuityTransactions extends ListRecords
{
    protected static string $resource = GratuityTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
