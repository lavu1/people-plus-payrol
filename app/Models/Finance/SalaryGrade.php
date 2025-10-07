<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use App\Models\Company\CompanyBranch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SalaryGrade extends Model
{
    protected  $fillable = ['grade_name', 'min_salary', 'max_salary', 'gratuity_percentage', 'pension_percentage', 'company_branch_id'];

    /**
     * Scope to filter salary grades by all branches of a specific company.
     */
    public function scopeByCompanyBranches(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }
        
        return $query->whereHas('companyBranch', function ($query) use ($companyId) {
            $query->where('company_id', $companyId); // Ensure the branches belong to the given company
        });
    }

    /**
     * SalaryGrade belongs to a company branch.
     */
    public function companyBranch()
    {
        return $this->belongsTo(CompanyBranch::class);
    }
    


}
