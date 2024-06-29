<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Armada;
use App\Models\Availability;
use App\Models\OrderHistory;
use App\Models\SuratJalan;
use Illuminate\Http\Request;

class LogistikController extends Controller
{
    public function index()
    {

        $orders = Order::where('shipment_status_id', 5)->orderBy('updated_at', 'asc')->get();

        return view('logistik.dashboard.index', compact('orders'));
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

        return view('logistik.details.index', compact('order', 'total', 'totalWeight', 'drivers', 'armadas'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'status' => 'required'
        ], [
            'status.required' => 'Status harus diisi'
        ]);

        // date jakarta time
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $order = Order::find($id);
        $order->shipment_status_id = $request->status;
        $order->updated_at = $date;
        $order->update();

        // update history
        $history = new OrderHistory();
        $history->order_id = $order->id;
        $history->shipment_status_id = $request->status;
        $history->user_id = auth()->user()->id;
        $history->note = 'Process By Logistic';
        $history->created_at = $date;
        $history->updated_at = $date;
        $history->save();

        return redirect()->route('logistik.firstW')->with('success', 'Berhasil')->with('description', 'Status Truck Telah Berhasil Diubah');
    }

    public function firstWeigh()
    {
        $orders = Order::where('shipment_status_id', 6)->get();

        $firstW = SuratJalan::get();
        // dd($firstW);
        return view('logistik.penimbangan.penimbangan-pertama', compact('orders', 'firstW'));
    }

    public function insertFirstWeigh($id, Request $request)
    {
        $request->validate([
            'firstW' => 'required|numeric|min:0'
        ], [
            'firstW.required' => 'Nilai Timbangan Harus Diisi',
            'firstW.numeric' => 'Nilai Timbangan Harus Berupa Angka',
            'firstW.min' => 'Nilai Timbangan Tidak Boleh 0'
        ]);

        // date jakarta time
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $order = Order::find($id);
        // $order->shipment_status_id = 7;
        // $order->updated_at = $date;
        // $order->update();

        $suratJalan = SuratJalan::find($id);
        if (!$suratJalan) {
            // Ambil Surat Jalan terakhir
            $lastSuratJalan = SuratJalan::orderBy('id', 'desc')->first();

            // Jika tidak ada Surat Jalan sebelumnya, mulai dari 10001
            if (!$lastSuratJalan) {
                $noSuratJalan = 10001;
            } else {
                // Ambil nomor Surat Jalan terakhir dan tambahkan 1
                $lastNoSuratJalan = (int)$lastSuratJalan->no_surat_jalan;
                $noSuratJalan = $lastNoSuratJalan + 1;
            }
        }

        // Buat Surat Jalan baru
        $suratJalan = new SuratJalan();
        $suratJalan->order_id = $id;
        $suratJalan->no_sj = $noSuratJalan;
        $suratJalan->empty_load_weight = $request->firstW;
        $suratJalan->save();


        // update history
        $history = new OrderHistory();
        $history->order_id = $order->id;
        $history->shipment_status_id = 6;
        $history->user_id = auth()->user()->id;
        $history->note = 'First Weighning';
        $history->created_at = $date;
        $history->updated_at = $date;
        $history->save();

        return redirect()->route('logistik.firstW')->with('success', 'Berhasil')->with('description', 'Berhasil Mengupdate Timbangan Pertama');
    }

    public function updateFirstWeigh($id, Request $request)
    {
        $request->validate([
            'firstW' => 'required|numeric|min:0',
            'id_surjal' => 'required'
        ], [
            'firstW.required' => 'Nilai Timbangan Harus Diisi',
            'firstW.numeric' => 'Nilai Timbangan Harus Berupa Angka',
            'firstW.min' => 'Nilai Timbangan Tidak Boleh 0'
        ]);

        // date jakarta time
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $order = Order::find($id);
        // $order->shipment_status_id = 7;
        // $order->updated_at = $date;
        // $order->update();

        $suratJalan = SuratJalan::find($request->id_surjal);
        $suratJalan->empty_load_weight = $request->firstW;
        $suratJalan->update();

        // update history
        $history = new OrderHistory();
        $history->order_id = $order->id;
        $history->shipment_status_id = 6;
        $history->user_id = auth()->user()->id;
        $history->note = 'Update First Weighning';
        $history->created_at = $date;
        $history->updated_at = $date;
        $history->save();

        return redirect()->route('logistik.firstW')->with('success', 'Berhasil')->with('description', 'Berhasil Mengupdate Timbangan Pertama');
    }
}
