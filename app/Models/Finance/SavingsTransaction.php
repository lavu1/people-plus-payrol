<?php

namespace App\Models\Finance;

use App\Models\Finance\Saving;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SavingsTransaction extends Model
{
    protected $fillable = ['savings_id', 'transaction_type', 'amount','payroll_id'];

    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('savings.companyEmployee.department.companyBranch', function (Builder $query) use ($companyId) {
                $query->where('company_id', $companyId);
        });
    }


    public function savings()
    {
        return $this->belongsTo(Saving::class);
    }
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
