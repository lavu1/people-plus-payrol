<?php

namespace App\Filament\Resources\Bank\BankBranchResource\Pages;

use App\Filament\Resources\Bank\BankBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankBranches extends ListRecords
{
    protected static string $resource = BankBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
