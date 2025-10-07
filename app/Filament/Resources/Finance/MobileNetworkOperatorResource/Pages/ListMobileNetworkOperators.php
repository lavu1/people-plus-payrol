<?php

namespace App\Filament\Resources\Finance\MobileNetworkOperatorResource\Pages;

use App\Filament\Resources\Finance\MobileNetworkOperatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMobileNetworkOperators extends ListRecords
{
    protected static string $resource = MobileNetworkOperatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
