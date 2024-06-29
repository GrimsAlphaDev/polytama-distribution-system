<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{

    public function dashboard()
    {

        $driverAvail = Availability::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->where('user_id', auth()->user()->id)->first();

        if ($driverAvail) {
            $status = $driverAvail->status;
        } else {
            // check if driver is on duty
            $order = Order::where('driver_id', auth()->user()->id)->where('shipment_status_id', '!=', 11)->first();
            if ($order) {
                $status = 2;
            } else {
                $status = 0;
            }
        }

        return view('driver.dashboard.index', compact('status'));
    }

    public function index()
    {

        $order = Order::where('driver_id', auth()->user()->id)->first();
        // dd($order);

        if($order){

            $total = $order->orderDetails->sum('total');
    
            $totalWeight = 0;
            foreach ($order->orderDetails as $orderDetail) {
                $totalWeight += $orderDetail->product->weight * $orderDetail->quantity;
            }
            
        } else {
            $total = 0;
            $totalWeight = 0;
        } 

        $histories = OrderHistory::where('order_id', $order->id)->orderBy('created_at', 'asc')->where('shipment_status_id', '>', 2)->get();

        return view('driver.shipment.index', compact('order', 'totalWeight', 'total', 'histories'));
    }

    public function updateStatusDriver($id, Request $request)
    {

        $request->validate([
            'status' => 'required'
        ], [
            'status.required' => 'Status harus diisi'
        ]);

        $availability = Availability::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->where('user_id', $id)->first();
        if ($availability) {
            $availability->status = $request->status;
            $availability->updated_at = now();
            $availability->update();
        } else {
            $create = new Availability();
            $create->user_id = $id;
            $create->status = $request->status;
            $create->save();
        }

        return redirect()->route('driver')->with('success', 'Sukses')->with('description', 'Status driver berhasil diubah');
    }

    public function updateStatus($id, Request $request){
        $request->validate([
            'shipment_status_id' => 'required|numeric'
        ], [
            'shipment_status_id.required' => 'Ada Kesalahan Pada Sistem, Silahkan Hubungi Admin',
            'shipment_status_id.numeric' => 'Ada Kesalahan Pada Sistem, Silahkan Hubungi Admin'
        ]);

        if($request->keterangan == null){
            $keterangan = '-';
        } else {
            $keterangan = $request->keterangan;
        }

        $order = Order::find($id);
        // update
        $order->shipment_status_id = $request->shipment_status_id;
        $order->keterangan = $keterangan;
        $order->update();

        // date jakarta time
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        // update history
        $history = new OrderHistory();
        $history->order_id = $order->id;
        $history->shipment_status_id = $request->shipment_status_id;
        $history->user_id = auth()->user()->id;
        $history->note = $keterangan;
        $history->created_at = $date;
        $history->updated_at = $date;
        $history->save();

        
        return redirect()->route('driver.shipment')->with('success', 'Sukses')->with('description', 'Status driver berhasil diubah');

    }
}
