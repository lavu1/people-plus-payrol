<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    protected $fillable = ['department_name', 'company_branch_id'];

    /**
     * Scope to filter departments by a specific company.
     */
    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->whereHas('companyBranch', function ($query) use ($companyId) {
            $query->where('company_id', $companyId); // Assuming the `company_branches` table has a `company_id` column
        });
    }

    /**
     * Scope to filter departments by a specific branch.
     */
    public function scopeByCompanyBranch(Builder $query, $companyBranchId)
    {
        return $query->where('company_branch_id', $companyBranchId);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
           // $model->company_branch_id = CompanyBranch::first()->id; // Set a default branch if necessary
        });
    }

    public function companyBranch()
    {
        return $this->belongsTo(CompanyBranch::class);
    }
}
