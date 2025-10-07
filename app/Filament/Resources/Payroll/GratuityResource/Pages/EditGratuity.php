<?php

namespace App\Filament\Resources\Payroll\GratuityResource\Pages;

use App\Filament\Resources\Payroll\GratuityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGratuity extends EditRecord
{
    protected static string $resource = GratuityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
