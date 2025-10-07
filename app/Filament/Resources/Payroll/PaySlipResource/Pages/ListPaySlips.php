<?php

namespace App\Filament\Resources\Payroll\PaySlipResource\Pages;

use App\Filament\Resources\Payroll\PaySlipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaySlips extends ListRecords
{
    protected static string $resource = PaySlipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
