<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Payroll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payslip extends Model
{
    protected $fillable = ['payroll_id', 'company_employee_id', 'gross_pay', 'net_pay', 'deductions_total', 'leave_value', 'gratuity_amount'];


    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('companyEmployee.department.companyBranch', function (Builder $query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }
}
