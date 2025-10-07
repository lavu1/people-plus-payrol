<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'bank_name',
        'bank_code',
    ];
    
    public function scopeByName() {
        return $this->where('bank_name', 'like', '%' . $this->name . '%');
    }
    
}
