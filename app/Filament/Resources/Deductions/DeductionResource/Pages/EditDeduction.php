<?php

namespace App\Filament\Resources\Deductions\DeductionResource\Pages;

use App\Filament\Resources\Deductions\DeductionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeduction extends EditRecord
{
    protected static string $resource = DeductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
