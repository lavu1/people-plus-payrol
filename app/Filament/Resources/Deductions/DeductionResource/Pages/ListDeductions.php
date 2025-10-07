<?php

namespace App\Filament\Resources\Deductions\DeductionResource\Pages;

use App\Filament\Resources\Deductions\DeductionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeductions extends ListRecords
{
    protected static string $resource = DeductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
