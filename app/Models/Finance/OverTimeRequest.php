<?php

namespace App\Models\Finance;

use App\Models\Company\CompanyEmployee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OverTimeRequest extends Model
{
    protected $fillable = [
        'over_time_type',
        'requested_hours',
        'justification',
        'dates_requested',
        'computed_cost',
        'status',
        'is_taxable',
        'hod_comments',
        'hr_comments',
        'supervisor_triggered',
        'company_employee_id',
    ];

    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('companyEmployee.department.companyBranch', function (Builder $query) use ($companyId) {
            $query->where('company_id', $companyId);
        });
    }//computed_cost

    protected static function booted()
    {
        static::creating(function ($model) {
            //dd($model);
            $companyEmployee = CompanyEmployee::find($model->company_employee_id);
            if (!$companyEmployee || !$companyEmployee->salary) {
                return; // Or handle error appropriately
            }

            //$overtimeR = OverTimeRequest::find($model->over_time_requests_id);
            $basicPay = $companyEmployee->salary;
            $hours = (float) $model->requested_hours;
            $rate = 1;

            if ($model->over_time_type === 'weekend' || $model->over_time_type === 'holidays') {
                $rate = 2;
            } elseif ($model->over_time_type === 'excess_hours') {
                $rate = 1.5;
            }

            $model->computed_cost = ($basicPay * $rate * $hours) / 192;
        });

        static::updating(function ($model) {
            //dd($model);
            $companyEmployee = CompanyEmployee::find($model->company_employee_id);
            if (!$companyEmployee || !$companyEmployee->salary) {
                return; // Or handle error appropriately
            }

            //$overtimeR = OverTimeRequest::find($model->over_time_requests_id);
            $basicPay = $companyEmployee->salary;
            $hours = (float) $model->requested_hours;
            $rate = 1;

            if ($model->over_time_type === 'weekend' || $model->over_time_type === 'holidays') {
                $rate = 2;
            } elseif ($model->over_time_type === 'excess_hours') {
                $rate = 1.5;
            }

            $model->computed_cost = ($basicPay * $rate * $hours) / 192;
        });
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class,'company_employee_id');
    }
    public function overTimeConfig()
    {
        return $this->hasOne(OverTimeConfig::class, 'over_time_type', 'over_time_type');
    }
}
