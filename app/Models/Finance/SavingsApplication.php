<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SavingsApplication extends Model
{
    protected $fillable = [
        'company_employee_id',
        's_type',
        'value',
        'reason',
        'status',
    ];

    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }
        return $query->whereHas('companyEmployee.user.company', function (Builder $query) use ($companyId) {
            $query->where('id', $companyId);
        });

//        return $query->whereHas('companyEmployee', function (Builder $query) use ($companyId) {
//            $query->where('company_id', $companyId);
//        });
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }
}
