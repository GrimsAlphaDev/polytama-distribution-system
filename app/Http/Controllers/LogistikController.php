<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class LogistikController extends Controller
{
    public function index(){

        $orders = Order::where('shipment_status_id', 5)->orderBy('updated_at', 'asc')->get();

        return view('logistik.dashboard.index', compact('orders'));
    }
}
