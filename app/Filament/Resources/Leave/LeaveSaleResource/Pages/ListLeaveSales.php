<?php

namespace App\Filament\Resources\Leave\LeaveSaleResource\Pages;

use App\Filament\Resources\Leave\LeaveSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveSales extends ListRecords
{
    protected static string $resource = LeaveSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
