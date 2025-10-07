<?php

namespace App\Models\Allowance;

use App\Models\Company\Company;
use App\Models\Company\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Allowance extends Model
{
    protected $fillable = ['allowance_name', 'allowance_type', 'value', 'description', 'status', 'is_taxable','recurring', 'position_id', 'company_id'];


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

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function employeeAllowances()
    {
        return $this->hasMany(EmployeeAllowance::class, 'allowances_id');
    }
}
