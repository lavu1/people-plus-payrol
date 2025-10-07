<?php

namespace App\Filament\Resources\Company\CompanyResource\Pages;

use App\Filament\Resources\Company\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => is_null(Auth::user()->current_company_id)),
//            Actions\CreateAction::make()
//                ->visible(fn () => Auth::user()->company()->doesntExist()),
        ];
    }
}
