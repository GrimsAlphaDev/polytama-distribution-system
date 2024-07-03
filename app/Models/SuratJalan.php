<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_sj',
        'order_id',
        'empty_load_weight',
        'loaded_weight',
        'doc_surjal'
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
