<?php

namespace App\Filament\Resources\Allowance\AllowanceResource\Pages;

use App\Filament\Resources\Allowance\AllowanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAllowance extends EditRecord
{
    protected static string $resource = AllowanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
