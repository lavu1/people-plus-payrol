<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable  = ['payment_method_type','payment_method_name','description'];

}
