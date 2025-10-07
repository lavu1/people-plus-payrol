<?php

namespace App\Models\Payroll;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Payroll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayrollTransactions extends Model
{
    protected $fillable = [
        'payroll_id',
        'company_employee_id',
        'gross_salary',
        'allowances',
        'deductions',
        'net_salary',
        'pay_date',
    ];

    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('payroll', function (Builder $query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }

    /**
     * Relationship to the Payroll model.
     */
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    /**
     * Relationship to the CompanyEmployee model.
     */
    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }
}
