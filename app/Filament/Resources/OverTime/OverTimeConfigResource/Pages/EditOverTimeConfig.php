<?php

namespace App\Filament\Resources\OverTime\OverTimeConfigResource\Pages;

use App\Filament\Resources\OverTime\OverTimeConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOverTimeConfig extends EditRecord
{
    protected static string $resource = OverTimeConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
