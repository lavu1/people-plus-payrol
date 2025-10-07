<?php

namespace App\Filament\Resources\Savings\EmployeeSavingResource\Pages;

use App\Filament\Resources\Savings\EmployeeSavingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeSaving extends EditRecord
{
    protected static string $resource = EmployeeSavingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
