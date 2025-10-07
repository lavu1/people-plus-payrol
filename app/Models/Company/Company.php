<?php

namespace App\Models\Company;

use App\Models\Finance\PaymentMethod;
use App\Models\Finance\SalaryGrade;
use App\Models\Industry\Sector;
use App\Models\Leave\leaveType;
use App\Models\Residency\Town;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'address',
        'email',
        'phone',
        'logo_url',
        'town_id',
        'pacra_number',
        'payment_method_id',
        'TPIN',
        'user_id'
    ];


   /* public function scopeByUser(Builder $query, $userId)
    {
        return $query->join('company_users', 'company_users.company_id', '=', 'companies.id')
            ->where('company_users.user_id', $userId)
            ->where('company_users.company_id', auth()->user()->current_company_id);
    }*/


    public function scopeByUser(Builder $query, $userId)
    {
        if (Auth::user()->roles->pluck('name')->contains('super_admin')) {
            return $query; // Skip filtering if user is a super admin
        }

        return $query->where('user_id', $userId);
    }



    // Automatically set the `user_id` when creating a company
    protected static function booted() {
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });

        // Update the logged-in user's `company_id` after creating a company
        static::created(function ($model) {
            $user = Auth::user();
            $user->current_company_id = $model->id;
            $user->save();
        });
    }


    public function companyBranch()
    {
        return $this->hasMany(CompanyBranch::class);
    }

    public function town()
    {
        return $this->belongsTo(Town::class);
    }


    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }

//    public function sector()
//    {
//        return $this->belongsTo(Sector::class);
//    }

    public function employees()
    {
        return $this->hasMany(CompanyEmployee::class);
    }

    public function salaryGrade()
    {
        return $this->hasMany(SalaryGrade::class);
    }

    public function leaveTypes()
    {
        return $this->hasMany(LeaveType::class);
    }
}
