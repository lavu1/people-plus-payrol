<?php

namespace App\Filament\Resources\Payroll\GratuityResource\Pages;

use App\Filament\Resources\Payroll\GratuityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGratuities extends ListRecords
{
    protected static string $resource = GratuityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
