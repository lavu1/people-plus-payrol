<?php

namespace App\Models\Finance;

use App\Models\Bank\Bank;
use App\Models\Company\CompanyEmployee;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankAccount extends Model
{
    protected $fillable = ['bank_account_number', 'bank_id', 'bank_branch_id', 'sort_code'];

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
