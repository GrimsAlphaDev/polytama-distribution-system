<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'Customer';

    protected $fillable = [
        'name',
        'email',
        'kota',
        'alamat',
        'no_telp'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    

}
