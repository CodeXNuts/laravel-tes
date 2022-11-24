<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table= 'orderdetails';

    public function order()
    {
        return $this->belongsTo(Order::class,'orderNumber','orderNumber');
    }

    public function product()
    {
        return $this->hasOne(Product::class,'productCode','productCode');
    }
}
