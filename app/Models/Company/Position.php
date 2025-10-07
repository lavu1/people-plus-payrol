<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Position extends Model
{
    protected $fillable = ['position_name', 'department_id'];

    /**
     * Scope to filter positions by a specific company.
     */
    public function scopeByCompany(Builder $query, $companyId)
    {

        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }
        
        return $query->whereHas('department.companyBranch', function ($query) use ($companyId) {
            $query->where('company_id', $companyId); // Ensure the company ID matches
        });
    }

    /**
     * Position belongs to a department.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
