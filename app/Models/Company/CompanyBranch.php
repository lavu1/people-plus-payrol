<?php

namespace App\Models\Company;

use App\Models\Company\CompanyEmployee;
use App\Models\Residency\Country;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class CompanyBranch extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = ['company_branch_name', 'company_branch_code', 'company_branch_email', 'company_branch_address', 'town_id', 'company_id'];


    public function scopeByCompany(Builder $query, $companyId) {

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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function employees()
    {
        return $this->hasMany(CompanyEmployee::class, 'company_branch_id');
    }
    public function departments()
    {
        return $this->hasMany(Department::class, 'id');
    }
}
