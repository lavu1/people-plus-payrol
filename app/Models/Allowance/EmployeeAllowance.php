<?php

namespace App\Models\Allowance;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Payroll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeAllowance extends Model
{
    protected $fillable = ['allowances_id','company_employee_id','payroll_id'];

    public function scopeByCompany(Builder $query, $companyId)
    {
        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('companyEmployee.department.companyBranch', function (Builder $query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class,'company_employee_id');
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function allowance()
    {
        return $this->belongsTo(Allowance::class,'allowances_id');
    }

}
