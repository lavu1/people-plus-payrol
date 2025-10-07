<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use App\Models\Company\CompanyBranch;
use App\Models\Company\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Deduction extends Model
{
    protected $fillable = ['company_id', 'name', 'd_type', 'value', 'is_statutory', 'destination', 'frequency','position_id'];

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
        return $this->belongsTo(Company::class,'company_id');
    }
    public function deductionTransactions()
    {
        return $this->hasMany(DeductionTransaction::class, 'deduction_id');
    }
    public function deduction()
    {
        return $this->belongsTo(Deduction::class, 'deduction_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
