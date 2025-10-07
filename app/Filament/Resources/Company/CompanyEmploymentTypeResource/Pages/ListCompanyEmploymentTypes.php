<?php

namespace App\Filament\Resources\Company\CompanyEmploymentTypeResource\Pages;

use App\Filament\Resources\Company\CompanyEmploymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyEmploymentTypes extends ListRecords
{
    protected static string $resource = CompanyEmploymentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
