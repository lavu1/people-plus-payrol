<?php

namespace App\Filament\Resources\Company\CompanyEmploymentTypeResource\Pages;

use App\Filament\Resources\Company\CompanyEmploymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCompanyEmploymentType extends EditRecord
{

    protected static string $resource = CompanyEmploymentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->visible(fn () => Auth::user()->hasRole('super_admin')),
        ];
    }
}
