<?php

namespace App\Filament\Resources\Savings\SavingResource\Pages;

use App\Filament\Resources\Savings\SavingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSaving extends EditRecord
{
    protected static string $resource = SavingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
