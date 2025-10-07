<?php

namespace App\Filament\Resources\Finance\AdvanceApplicationResource\Pages;

use App\Filament\Resources\Finance\AdvanceApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvanceApplication extends EditRecord
{
    protected static string $resource = AdvanceApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
