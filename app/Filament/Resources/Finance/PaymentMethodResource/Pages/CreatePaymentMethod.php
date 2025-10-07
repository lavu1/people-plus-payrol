<?php

namespace App\Filament\Resources\Finance\PaymentMethodResource\Pages;

use App\Filament\Resources\Finance\PaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentMethod extends CreateRecord
{
    protected static string $resource = PaymentMethodResource::class;
}
