<?php

namespace App\Filament\Resources\Leave\LeaveBalanceResource\Pages;

use App\Filament\Resources\Leave\LeaveBalanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveBalances extends ListRecords
{
    protected static string $resource = LeaveBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
