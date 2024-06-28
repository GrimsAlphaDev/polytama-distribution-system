<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'order_histories';

    protected $fillable = [
        'order_id',
        'shipment_status_id',
        'user_id',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shipmentStatus()
    {
        return $this->belongsTo(ShipmentStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
