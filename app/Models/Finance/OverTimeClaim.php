<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use App\Models\Company\CompanyEmployee;
use App\Models\Company\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OverTimeClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'actual_hours',
        'computed_cost',
        'adjusted_hours',
        'final_hours',
        'over_time_requests_id',
        'company_employee_id',
        'payroll_id'
    ];

    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('companyEmployee.user', function (Builder $query) use ($companyId) {
            $query->where('current_company_id', $companyId);
        });
    }//

    protected static function booted()
    {
        static::creating(function ($model) {
            $companyEmployee = CompanyEmployee::find($model->company_employee_id);
            if (!$companyEmployee || !$companyEmployee->salary) {
                return; // Or handle error appropriately
            }

            $basicPay = $companyEmployee->salary;
            $hours = (float) $model->final_hours;
            $rate = 1;

            if ($model->over_time_type === 'weekend' || $model->over_time_type === 'holidays') {
                $rate = 2;
            } elseif ($model->over_time_type === 'excess_hours') {
                $rate = 1.5;
            }

            $model->computed_cost = ($basicPay * $rate * $hours) / 192;
        });
    }

    public function overtTimeRequest()
    {
        return $this->belongsTo(OverTimeRequest::class,'over_time_requests_id');
    }
    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class,'company_employee_id');
    }
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
