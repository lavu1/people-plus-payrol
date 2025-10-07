<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class MobileNetworkOperator extends Model
{
    protected $fillable = ['operator_name', 'operator_code', 'operator_logo_url', 'max_transfer_amount'];
}
