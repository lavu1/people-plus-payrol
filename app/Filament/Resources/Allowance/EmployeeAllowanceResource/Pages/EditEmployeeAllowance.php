<?php

namespace App\Filament\Resources\Allowance\EmployeeAllowanceResource\Pages;

use App\Filament\Resources\Allowance\EmployeeAllowanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeAllowance extends EditRecord
{
    protected static string $resource = EmployeeAllowanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
