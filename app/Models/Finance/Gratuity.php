<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Gratuity extends Model
{
    protected $fillable = ['company_employee_id', 'value', 'g_type', 'notes'];

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
        return $this->belongsTo(CompanyEmployee::class);
    }
}
