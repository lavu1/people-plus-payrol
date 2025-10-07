<?php

namespace App\Filament\Resources\Company\CompanyBranchResource\Pages;

use App\Filament\Resources\Company\CompanyBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyBranches extends ListRecords
{
    protected static string $resource = CompanyBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
