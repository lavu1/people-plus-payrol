<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdvanceApplication extends Model
{

    protected $fillable = [
        'company_employee_id',
        'amount',
        'reason',
        'a_type',
        'value',
        'frequency',
        'status',
    ];

    public function scopeByCompany(Builder $query, $companyId) {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }
        return $query->whereHas('companyEmployee.department.companyBranch', function (Builder $query) use ($companyId) {
            $query->where('company_id', $companyId);
        });

//        return $query->whereHas('user', function (Builder $query) use ($companyId) {
//            $query->where('current_company_id', $companyId);
//        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class,'company_employee_id');
    }
}
