<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Armada;
use App\Models\Availability;
use App\Models\OrderHistory;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use TCPDF;

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
        $surat_jalan = SuratJalan::where('order_id', $id)->first();

        // join order with order with surat jalan
        if ($surat_jalan) {
            $order->surat_jalan = $surat_jalan;
        }

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

        $note = '';
        if ($request->status == 6) {
            $note = 'Penimbangan Pertama';
        } elseif ($request->status == 7) {
            $note = 'Loading By Logistic';
        } elseif ($request->status == 8) {
            $note = 'Penimbangan Kedua';
        }

        // update history
        $history = new OrderHistory();
        $history->order_id = $order->id;
        $history->shipment_status_id = $request->status;
        $history->user_id = auth()->user()->id;
        $history->note = $note;
        $history->created_at = $date;
        $history->updated_at = $date;
        $history->save();

        if ($request->status == 6) {
            return redirect()->route('logistik.firstW')->with('success', 'Berhasil')->with('description', 'Status Order Telah Berhasil Diubah');
        } elseif ($request->status == 7) {
            return redirect()->route('logistik.loading.barang')->with('success', 'Berhasil')->with('description', 'Status Order Telah Berhasil Diubah');
        } elseif ($request->status == 8) {
            return redirect()->route('logistik.secondW')->with('success', 'Berhasil')->with('description', 'Status Order Telah Berhasil Diubah');
        }
    }

    public function firstWeigh()
    {
        $orders = Order::where('shipment_status_id', 6)->get();

        $firstW = SuratJalan::get();

        if ($firstW) {
            foreach ($orders as $or) {
                foreach ($firstW as $f) {
                    if ($or->id == $f->order_id) {
                        $or->surat_jalan = $f;
                    }
                }
            }
        }

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

        $suratJalan = SuratJalan::first();

        if (!$suratJalan) {
            $noSuratJalan = 10001;
        } else {
            // get the last no surat jalan
            $lastSuratJalan = SuratJalan::latest()->first();
            $lastNoSuratJalan = (int)$lastSuratJalan->no_sj;
            $noSuratJalan = $lastNoSuratJalan + 1;
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

    public function loadingBarang()
    {
        $orders = Order::where('shipment_status_id', 7)->orderBy('updated_at', 'asc')->get();

        return view('logistik.loading.index', compact('orders'));
    }

    public function secondWeigh()
    {
        $orders = Order::where('shipment_status_id', 8)->get();

        $sj = SuratJalan::get();

        if ($sj) {
            foreach ($orders as $or) {
                foreach ($sj as $s) {
                    if ($or->id == $s->order_id) {
                        $or->surat_jalan = $s;
                    }
                }
            }
        }

        // dd($firstW);
        return view('logistik.penimbangan.penimbangan-kedua', compact('orders'));
    }

    public function insertSecondWeigh($id, Request $request)
    {
        // dd($request->all());

        $request->validate([
            'secondW' => 'required|numeric|min:0'
        ], [
            'secondW.required' => 'Nilai Timbangan Harus Diisi',
            'secondW.numeric' => 'Nilai Timbangan Harus Berupa Angka',
            'secondW.min' => 'Nilai Timbangan Tidak Boleh 0'
        ]);

        // date jakarta time
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        $order = Order::find($id);

        $suratJalan = SuratJalan::where('order_id', $id)->first();

        if (!$suratJalan) {
            return redirect()->route('logistik.secondW')->withErrors([
                'Error' => 'Surat Jalan Tidak Ditemukan',
            ]);
        }

        if (intval($request->secondW) - $suratJalan->empty_load_weight > $order->armada->max_load) {
            return redirect()->route('logistik.secondW')->withErrors([
                'Error' => 'Berat Melebihi Kapasitas Armada',
            ]);
        }

        // Buat Surat Jalan baru
        $suratJalan->loaded_weight = $request->secondW;
        $suratJalan->update();

        // update history
        $history = new OrderHistory();
        $history->order_id = $order->id;
        $history->shipment_status_id = 8;
        $history->user_id = auth()->user()->id;
        $history->note = 'Melakukan Penimbangan Kedua';
        $history->created_at = $date;
        $history->updated_at = $date;
        $history->save();

        return redirect()->route('logistik.secondW')->with('success', 'Berhasil')->with('description', 'Berhasil Mengupdate Timbangan Pertama');
    }



    public function terbitkan_suratJalan($id, Request $request)
    {
        // Path to custom logo
        $logoPath = public_path('assets/img/logo-1.png');

        // Create new TCPDF instance
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('MIS Departement');
        $pdf->SetAuthor('PT Polytama Propindo');
        $pdf->SetTitle('Surat Jalan');
        $pdf->SetSubject('Surat Jalan');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // Set default header data
        $pdf->SetHeaderData($logoPath, PDF_HEADER_LOGO_WIDTH, 'PT POLYTAMA PROPINDO', "Jl. Jendral Sudirman Kav. 10-11 Mid Plaza 2 20 Floor Jakarta 10220\nMain Office Phone : +62 215703883 Fax: +62 21 5704468");

        // Set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Add a page
        $pdf->AddPage();

        // Add logo using Image() method
        $pdf->Image($logoPath, 15, 3, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);

        // Set font
        $pdf->SetFont('helvetica', '', 10);
        // Set position for main content
        $pdf->SetY(25); // Adjust Y position as needed

        // Define main HTML content
        $html =  '
            <h2 style="text-align:center;">SURAT JALAN</h2>
            <table cellspacing="0" cellpadding="1" border="1">
                <tr>
                    <td>No SJ</td>
                    <td></td>
                    <td>Tanggal</td>
                    <td>01 Jan 1970</td>
                </tr>
                <tr>
                    <td>Atas Permintaan</td>
                    <td></td>
                    <td>Dikirim Kepada</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dikirim Oleh</td>
                    <td></td>
                    <td>No KO</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No Polisi</td>
                    <td></td>
                    <td>No PO</td>
                    <td></td>
                </tr>
            </table>
            <br>
            <table cellspacing="0" cellpadding="1" border="1">
                <tr>
                    <th>NO</th>
                    <th>NAMA BARANG</th>
                    <th>LOT</th>
                    <th>JUMLAH</th>
                    <th>CATATAN</th>
                </tr>
                <tr>
                    <td height="100"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <table cellspacing="0" cellpadding="1" border="0">
                <tr>
                    <td>Dikeluarkan Oleh</td>
                    <td></td>
                    <td>Dikirim Oleh</td>
                    <td></td>
                    <td>Diterima Oleh</td>
                </tr>
                <tr>
                    <td>Logistic Manager PT Polytama Propindo</td>
                    <td></td>
                    <td>Tanggal WIB</td>
                    <td></td>
                    <td>Kepala Gudang Pelanggan</td>
                </tr>
            </table>
        ';

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF
        $pdf->Output('surat_jalan.pdf', 'I');

        return view('logistik.details.index', compact('order', 'total', 'totalWeight', 'drivers', 'armadas'));
    }
}
