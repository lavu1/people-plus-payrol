<?php

namespace App\Filament\Resources\Company\CompanyTransactionsResource\Pages;

use App\Filament\Resources\Company\CompanyTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyTransactions extends ListRecords
{
    protected static string $resource = CompanyTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
