<?php

namespace App\Filament\Resources\OverTime\OverTimeConfigResource\Pages;

use App\Filament\Resources\OverTime\OverTimeConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOverTimeConfigs extends ListRecords
{
    protected static string $resource = OverTimeConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
