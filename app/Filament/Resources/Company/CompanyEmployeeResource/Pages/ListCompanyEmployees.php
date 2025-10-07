<?php

namespace App\Filament\Resources\Company\CompanyEmployeeResource\Pages;

use App\Filament\Resources\Company\CompanyEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyEmployees extends ListRecords
{
    protected static string $resource = CompanyEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
