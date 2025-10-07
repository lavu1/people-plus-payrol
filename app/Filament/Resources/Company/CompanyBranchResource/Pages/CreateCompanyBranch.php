<?php

namespace App\Filament\Resources\Company\CompanyBranchResource\Pages;

use App\Filament\Resources\Company\CompanyBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCompanyBranch extends CreateRecord
{


    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $data['company_id'] = Auth::user()->current_company_id;
        //dd($data);
        $record =  static::getModel()::create($data);
        return $record;
    }
    protected static string $resource = CompanyBranchResource::class;
}
