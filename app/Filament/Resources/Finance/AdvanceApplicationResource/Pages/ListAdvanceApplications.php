<?php

namespace App\Filament\Resources\Finance\AdvanceApplicationResource\Pages;

use App\Filament\Resources\Finance\AdvanceApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvanceApplications extends ListRecords
{
    protected static string $resource = AdvanceApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
