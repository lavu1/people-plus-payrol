<?php

namespace App\Filament\Resources\OverTime\OverTimeClaimResource\Pages;

use App\Filament\Resources\OverTime\OverTimeClaimResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOverTimeClaims extends ListRecords
{
    protected static string $resource = OverTimeClaimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
