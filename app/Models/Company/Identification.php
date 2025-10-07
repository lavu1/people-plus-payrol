<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    protected $fillable = ['identification_type', 'identification_number', 'nrc_url', 'photo_url', 'company_employee_id'];

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }
}
