<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayrollUpload extends Model
{
    protected $fillable = [
        'employee_name',
        'employee_number',
        'bank_details',
        'mobile_money_phone_number',
        'social_security_number',
        'tpin',
        'date_of_birth',
        'email',
        'basic_pay',
        'pay_type',
        'leave_days_taken',
        'overtime_hours_payable',
        'allowance_name',
        'allowance_amount'];

    public function scopeByCompany(Builder $query, $companyId)
    {
        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }
        
        return $query->where('company_id', $companyId);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
