<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class GratuityTransactions extends Model
{
    protected $fillable = ['gratuity_id', 'amount','payroll_id'];
    //

    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('gratuity.companyEmployee.department.companyBranch', function (Builder $query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
    public function gratuity()
    {
        return $this->belongsTo(Gratuity::class);
    }
}
