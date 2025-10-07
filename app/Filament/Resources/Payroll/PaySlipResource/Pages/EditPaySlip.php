<?php

namespace App\Filament\Resources\Payroll\PaySlipResource\Pages;

use App\Filament\Resources\Payroll\PaySlipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaySlip extends EditRecord
{
    protected static string $resource = PaySlipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
