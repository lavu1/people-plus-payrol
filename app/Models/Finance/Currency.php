<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['currency_name', 'currency_code', 'symbol', 'exchange_rate', 'is_active'];
}
