<?php

namespace App\Models\Company;

use App\Models\Company\CompanyEmployee;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $fillable = ['next_of_kin_name', 'next_of_kin_identification_number', 'next_of_kin_phone', 'next_of_kin_email', 'next_of_kin_address', 'town_id', 'company_employee_id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class,'company_employee_id');
    }
}
