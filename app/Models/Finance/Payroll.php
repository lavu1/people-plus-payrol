<?php

namespace App\Models\Finance;
use App\Models\Allowance\EmployeeAllowance;
use App\Models\Company\Company;
use App\Models\Payroll\PayrollTransactions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Payroll extends Model
{
    protected $fillable = ['company_id', 'month', 'processed'];

    public function scopeByCompany(Builder $query, $companyId)
    {
        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->where('company_id', $companyId);
    }
    protected static function booted() {
        static::creating(function ($model) {
            $company_id = Auth::user()->current_company_id;
            $model->company_id = Company::where('id',$company_id)->first()->id;
        });
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function payrollTransactions()
    {
        return $this->hasOne(PayrollTransactions::class,'payroll_id');
    }

    public function employeeAllowances(): HasMany
    {
        return $this->hasMany(EmployeeAllowance::class);
    }

    public function transactions()
    {
        return $this->hasMany(PayrollTransactions::class);
    }

    public function employeedeductions()
    {
        return $this->hasMany(DeductionTransaction::class);
    }

}
