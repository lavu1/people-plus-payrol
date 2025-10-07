<?php

namespace App\Models\Leave;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LeaveType extends Model
{
    protected $fillable = ['leave_type_name', 'company_id'];

    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('company', function (Builder $query) use ($companyId) {
            $query->where('id', $companyId);
        });
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
}
