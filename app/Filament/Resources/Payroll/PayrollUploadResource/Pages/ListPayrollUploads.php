<?php

namespace App\Filament\Resources\Payroll\PayrollUploadResource\Pages;

use App\Filament\Resources\Payroll\PayrollUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayrollUploads extends ListRecords
{
    protected static string $resource = PayrollUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
