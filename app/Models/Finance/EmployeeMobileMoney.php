<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\MobileNetworkOperator;
use Illuminate\Database\Eloquent\Model;

class EmployeeMobileMoney extends Model
{
    protected $fillable = ['company_employee_id', 'mobile_money_number', 'mno_id'];

    public function mno()
    {
        return $this->belongsTo(MobileNetworkOperator::class);
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }

}
