<?php

namespace App\Filament\Resources\Deductions\EmployeeDeductionResource\Pages;

use App\Filament\Resources\Deductions\EmployeeDeductionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeDeduction extends EditRecord
{
    protected static string $resource = EmployeeDeductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
