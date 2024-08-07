<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Availability;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderRequestController extends Controller
{
    public function index()
    {

        // get order request signed by marketing to be processed by transporter

        $orderRequests = Order::where('transporter_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        return view('transporter.order-request.index', compact('orderRequests'));
    }

    public function show($id)
    {
        $order = Order::find($id);

        $total = $order->orderDetails->sum('total');

        // count total weight order
        $totalWeight = 0;
        foreach ($order->orderDetails as $orderDetail) {
            $totalWeight += $orderDetail->product->weight * $orderDetail->quantity;
        }

        // check availability driver created at is today
        $drivers = Availability::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->where('status', 1)->get();

        // get armada
        $armadas = Armada::where('user_id', Auth()->user()->id)->where('condition', 'Baik')->where('status', 'Available')->where('max_load', '>=', $totalWeight)->get();

        return view('transporter.order-request.show', compact('order', 'total', 'totalWeight', 'drivers', 'armadas'));
    }

    public function accept($id, Request $request)
    {
        $request->validate([
            'driver_id' => 'required',
            'armada_id' => 'required',
        ],[
            'driver_id.required' => 'Dimohon untuk memilih driver terlebih dahulu',
            'armada_id.required' => 'Dimohon untuk memilih armada terlebih dahulu',
        ]);

        if($request->keterangan == null){
            $keterangan = '-';
        } else {
            $keterangan = $request->keterangan;
        }

        $order = Order::where('order_number', $id)->first();
        $order->driver_id = $request->driver_id;
        $order->armada_id = $request->armada_id;
        $order->shipment_status_id = 3;
        $order->keterangan = $keterangan;
        $order->update();

        $avaibility = Availability::where('user_id', $request->driver_id)->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->first();
        $avaibility->status = 2;
        $avaibility->update();

        $armada = Armada::find($request->armada_id);
        $armada->status = 'On Shipping';
        $armada->update();

        // get date jakarta
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        // update history
        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $order->id;
        $orderHistory->shipment_status_id = 3;
        $orderHistory->user_id = Auth()->user()->id;
        $orderHistory->note = $keterangan;
        $orderHistory->created_at = $date;
        $orderHistory->updated_at = $date;
        $orderHistory->save();

        return redirect()->route('order-request')->with('success', 'Sukses')->with('description', 'Order request accepted successfully');

    }

    public function reject($id, Request $request)
    {

        $request->validate([
            'keterangan' => 'required'
        ], [
            'keterangan.required' => 'Dimohon untuk mengisi keterangan alasan penolakan'
        ]);

        $order = Order::where('order_number', $id)->first();
        $order->keterangan = $request->keterangan;
        $order->shipment_status_id = 2;
        $order->update();

        // get date jakarta
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        // update history
        $orderHistory = new OrderHistory();
        $orderHistory->order_id = $order->id;
        $orderHistory->shipment_status_id = 2;
        $orderHistory->user_id = Auth()->user()->id;
        $orderHistory->note = $request->keterangan;
        $orderHistory->created_at = $date;
        $orderHistory->updated_at = $date;
        $orderHistory->save();

        return redirect()->route('order-request')->with('success', 'Sukses')->with('description', 'Order request rejected successfully');
    }

}
