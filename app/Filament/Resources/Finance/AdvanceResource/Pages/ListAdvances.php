<?php

namespace App\Filament\Resources\Finance\AdvanceResource\Pages;

use App\Filament\Resources\Finance\AdvanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvances extends ListRecords
{
    protected static string $resource = AdvanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
