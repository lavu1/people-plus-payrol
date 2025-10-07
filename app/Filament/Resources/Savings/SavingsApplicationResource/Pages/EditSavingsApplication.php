<?php

namespace App\Filament\Resources\Savings\SavingsApplicationResource\Pages;

use App\Filament\Resources\Savings\SavingsApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSavingsApplication extends EditRecord
{
    protected static string $resource = SavingsApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
