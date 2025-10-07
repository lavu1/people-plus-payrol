<?php

namespace App\Models\Company;

use App\Models\Company\CompanyEmployee;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['phone', 'email', 'address', 'province_id', 'town_id', 'company_employee_id'];

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
        return $this->belongsTo(CompanyEmployee::class);
    }
}
