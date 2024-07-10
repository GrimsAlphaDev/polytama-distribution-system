<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\SuratJalan;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{

    public function dashboard()
    {

        $order = Order::where('driver_id', auth()->user()->id)->where('shipment_status_id', '!=', 11)->first();
        $driverAvail = Availability::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->where('user_id', auth()->user()->id)->first();
        
        if ($order) {
            $status = 2;
        } else {
            if ($driverAvail) {
                $status = $driverAvail->status;
            } else {
                $status = 0;
            }
        }

        $avail = Availability::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return view('driver.dashboard.index', compact('status', 'avail'));
    }

    public function index()
    {

        $order = Order::where('driver_id', auth()->user()->id)->where('shipment_status_id', '!=', 11)->first();
        // dd($order);

        if ($order) {

            $total = $order->orderDetails->sum('total');

            $totalWeight = 0;
            foreach ($order->orderDetails as $orderDetail) {
                $totalWeight += $orderDetail->product->weight * $orderDetail->quantity;
            }

            $surat_jalan = SuratJalan::where('order_id', $order->id)->first();

            // join order with order with surat jalan
            if ($surat_jalan) {
                $order->surat_jalan = $surat_jalan;
            }

            $histories = OrderHistory::where('order_id', $order->id)->orderBy('created_at', 'asc')->where('shipment_status_id', '>', 2)->get();
        } else {
            $order = null;
            $total = 0;
            $totalWeight = 0;
            $histories = [];
        }


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

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'shipment_status_id' => 'required|numeric'
        ], [
            'shipment_status_id.required' => 'Ada Kesalahan Pada Sistem, Silahkan Hubungi Admin',
            'shipment_status_id.numeric' => 'Ada Kesalahan Pada Sistem, Silahkan Hubungi Admin'
        ]);


        if ($request->keterangan == null) {
            $keterangan = '-';
        } else {
            $keterangan = $request->keterangan;
        }

        if($request->shipment_status_id == 11){
            $request->validate([
                'updatedSJ' => 'required'
            ], [
                'updatedSJ.required' => 'Surat Jalan Terbaru Harus Diupload'
            ]);

            $pdf = $request->file('updatedSJ');
            // update to base64 encode
            $pdf_base64 = base64_encode(file_get_contents($pdf));

            $sj = SuratJalan::where('order_id', $id)->first();
            $sj->doc_surjal = $pdf_base64;
            $sj->updated_at = now();
            $sj->update();
        }

        $order = Order::find($id);
        $order->shipment_status_id = $request->shipment_status_id;
        $order->keterangan = $keterangan;
        $order->updated_at = now();
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


        return redirect()->route('driver.shipment')->with('success', 'Sukses')->with('description', 'Berhasil Menyelesaikan Pengiriman');
    }

    public function shipmentHistory()
    {
        $orders = OrderHistory::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return view('driver.shipment.history', compact('orders'));
    }
}
