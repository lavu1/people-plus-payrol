<?php

namespace App\Filament\Resources\OverTime\OverTimeRequestResource\Pages;

use App\Filament\Resources\OverTime\OverTimeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOverTimeRequests extends ListRecords
{
    protected static string $resource = OverTimeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
