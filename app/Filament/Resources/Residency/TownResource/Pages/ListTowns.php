<?php

namespace App\Filament\Resources\Residency\TownResource\Pages;

use App\Filament\Resources\Residency\TownResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTowns extends ListRecords
{
    protected static string $resource = TownResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
