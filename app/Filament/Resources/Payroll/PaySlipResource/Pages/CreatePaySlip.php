<?php

namespace App\Filament\Resources\Payroll\PaySlipResource\Pages;

use App\Filament\Resources\Payroll\PaySlipResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaySlip extends CreateRecord
{
    protected static string $resource = PaySlipResource::class;
}
