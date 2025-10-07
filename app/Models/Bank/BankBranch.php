<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    protected $fillable = [
        'branch_name',
        'branch_code',
        'bank_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
