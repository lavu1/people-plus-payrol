<?php

namespace App\Filament\Resources\Savings\SavingsApplicationResource\Pages;

use App\Filament\Resources\Savings\SavingsApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSavingsApplications extends ListRecords
{
    protected static string $resource = SavingsApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
