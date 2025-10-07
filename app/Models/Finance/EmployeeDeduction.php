<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeDeduction extends Model
{
    protected $fillable = ['company_employee_id', 'total_savings','deduction_id','payroll_id'];


    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('companyEmployee', function (Builder $query) use ($companyId) {
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

    public function deduction()
    {
        return $this->belongsTo(Deduction::class);
    }

}
