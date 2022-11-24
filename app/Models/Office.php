<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $primaryKey = 'officeCode';

    public function employees()
    {
        return $this->hasMany(Employee::class,'officeCode');
    }

    
}
