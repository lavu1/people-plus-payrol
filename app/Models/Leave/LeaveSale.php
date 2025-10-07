<?php

namespace App\Models\Leave;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Payroll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LeaveSale extends Model
{
    protected $fillable = ['company_employee_id','reason', 'leave_days_sold', 'sale_amount', 'status','payroll_id'];

    public function scopeByCompany(Builder $query, $companyId)
    {
        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('companyEmployee.user.company', function (Builder $query) use ($companyId) {
            $query->where('id', $companyId);
        });
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
