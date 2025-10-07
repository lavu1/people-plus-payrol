<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use App\Models\Company\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OverTimeConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'over_time_type',
        'hourly_rate',
        'calculation_rate',
        'status',
        'is_taxable',
        'position_id',
        'company_id',
    ];

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

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
