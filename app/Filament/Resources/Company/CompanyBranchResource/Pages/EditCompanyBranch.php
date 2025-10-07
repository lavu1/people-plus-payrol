<?php

namespace App\Filament\Resources\Company\CompanyBranchResource\Pages;

use App\Filament\Resources\Company\CompanyBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyBranch extends EditRecord
{
    protected static string $resource = CompanyBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
