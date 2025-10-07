<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CompanyEmploymentType extends Model
{
    protected $fillable = [
        'type_name',
        'description',
       // 'company_id',
    ];

    public function scopeByCompany(Builder $query, $companyId) {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

       // return $query->where('company_id', $companyId);
    }

//    protected static function booted() {
//        static::creating(function ($model) {
//            $company_id = Auth::user()->current_company_id;
//            $model->company_id = Company::where('id',$company_id)->first()->id;
//            //$model->company_id = Company::first()->id;
//        });
//    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
