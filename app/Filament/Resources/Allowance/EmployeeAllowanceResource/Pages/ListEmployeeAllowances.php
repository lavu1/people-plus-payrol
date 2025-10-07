<?php

namespace App\Filament\Resources\Allowance\EmployeeAllowanceResource\Pages;

use App\Filament\Resources\Allowance\EmployeeAllowanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeAllowances extends ListRecords
{
    protected static string $resource = EmployeeAllowanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
