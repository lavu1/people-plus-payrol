<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Deduction;
use App\Models\Finance\Payroll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeductionTransaction extends Model
{
    protected $fillable = ['deduction_id', 'company_employee_id', 'payroll_id', 'amount', 'transaction_date'];


    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }
        
        return $query->whereHas('companyEmployee.department.companyBranch', function (Builder $query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }

    public function deduction()
    {
        return $this->belongsTo(Deduction::class, 'deduction_id');
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id');
    }
}
