<?php

namespace App\Models\Company;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CompanyUsers extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
    ];

    /**
     * Define the relationship to the Company model.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
