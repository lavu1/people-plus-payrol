<?php

namespace App\Filament\Resources\Payroll\PayrollUploadResource\Pages;

use App\Filament\Resources\Payroll\PayrollUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayrollUpload extends EditRecord
{
    protected static string $resource = PayrollUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
