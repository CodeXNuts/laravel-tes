<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'orderNumber';

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customerNumber');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class,'orderNumber','orderNumber');
    }

    
}
