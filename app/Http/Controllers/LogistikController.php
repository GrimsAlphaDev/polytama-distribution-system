<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Armada;
use App\Models\Availability;
use App\Models\OrderHistory;
use App\Models\SuratJalan;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use TCPDF;

class LogistikController extends Controller
{
    public function index()
    {

        $orders = Order::where('shipment_status_id', 5)->orderBy('updated_at', 'asc')->get();

        $terbited = Order::where('shipment_status_id', 9)->orderBy('updated_at', 'asc')->get();

        return view('logistik.dashboard.index', compact('orders', 'terbited'));
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

        $orders = Order::find($id);

        $sj = SuratJalan::get();

        if ($sj) {
            foreach ($sj as $s) {
                if ($orders->id == $s->order_id) {
                    $orders->surat_jalan = $s;
                }
            }
        }

        // count total weight order
        $totalWeight = 0;
        foreach ($orders->orderDetails as $orderDetail) {
            $totalWeight += $orderDetail->product->weight * $orderDetail->quantity;
        }

        // get now date base on jakarta
        date_default_timezone_set('Asia/Jakarta');
        // sate $date to 14 maret 2021 format
        $date = date('d F Y');

        $transporter = User::where('id', $orders->transporter_id)->first();

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
            <table cellspacing="0" cellpadding="1" border="0">
                <tr>
                    <td>No SJ </td>
                    <td>: ' . htmlspecialchars($orders->surat_jalan->no_sj, ENT_QUOTES, 'UTF-8') .
            '</td>
                    <td>Nomor Pesanan</td>
                    <td>: ' . $orders->order_number . '</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: ' . $date . '</td>
                    <td>No Polisi</td>
                    <td>: ' . $orders->armada->license_plate . '</td>
                </tr>
                <tr>
                    <td>Beban Muatan Produk </td>
                    <td>: ' . $totalWeight . ' KG</td>
                    <td>Total Beban:</td>
                    <td>: ' . $orders->surat_jalan->loaded_weight . ' KG</td>
                </tr>
                <tr>
                    <td>Atas Permintaan: </td>
                    <td></td>
                    <td>Dikirim Oleh:</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight:bold;">' . $orders->customer->name . '</td>
                    <td colspan="2" style="font-weight:bold;">' . $orders->driver->name . '</td>
                    <td></td>
                </tr>
                <tr>
                    <td>' . $orders->customer->alamat . '</td>
                    <td></td>
                    <td>' . $orders->driver->email . '</td>
                    <td></td>
                </tr>
                
            </table>

            <br><br>
            
            <table cellspacing="1" cellpadding="1" border="1" style="border: none;">
                <thead>
                    <tr style="background-color: lightgrey;">
                        <th style="font-weight: bold; text-align: center;">NO</th>
                        <th style="font-weight: bold; text-align: center;">NAMA BARANG</th>
                        <th style="font-weight: bold; text-align: center;">BERAT</th>
                        <th style="font-weight: bold; text-align: center;">JUMLAH</th>
                        <th style="font-weight: bold; text-align: center;">HARGA</th>
                    </tr>
                </thead>
                <tbody>
        ';

        $no = 1;
        foreach ($orders->orderDetails as $orderDetail) {
            $html .= '
                <tr>
                    <td style="text-align: center; border: none;">' . $no++ . '</td>
                    <td style="text-align: center; border: none;">' . $orderDetail->product->name . '</td>
                    <td style="text-align: center; border: none;">' . $orderDetail->product->weight . ' KG</td>
                    <td style="text-align: center; border: none;">' . $orderDetail->quantity . '</td>
                    <td style="text-align: left; border: none;"> Rp. ' . number_format($orderDetail->total, 0, ',', '.') . '</td>
                </tr>
            ';
        }


        $html .= '
                <tr>
                    <td height="100"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                </tr>
            </table>

            <br><br>
            <table cellspacing="0" cellpadding="1" border="0">
                <tr>
                    <td colspan="2" style="text-align:center;">Dikeluarkan Oleh</td>
                    <td style="text-align:center;"></td>
                    <td colspan="2" style="text-align:center;">Diterima Oleh</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;"><img src="'. public_path('assets/qr/logistic_manager.png') .'" width="100"/></td>
                    <td style="text-align:center;"></td>
                    <td colspan="2" style="text-align:center;">Kepala Gudang Pelanggan</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; font-weight:bold;">Logistic Manager PT Polytama Propindo</td>
                    <td style="text-align:center;"></td>
                    <td colspan="2" style="text-align:center;">Kepala Gudang Pelanggan</td>
                </tr>
            </table>';

        // Ensure you output the HTML content to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF
        $pdfContent = $pdf->Output('surat_jalan.pdf', 'S');

        $base64PDF = base64_encode($pdfContent);

        // work
        // dd($base64PDF);

        try {
            $surjal = SuratJalan::find($orders->surat_jalan->id);
            $surjal->doc_surjal = $base64PDF;
            $surjal->update();

            // update shipment status
            // find order
            $orderUpdate = Order::find($orders->id);
            $orderUpdate->shipment_status_id = 9;
            $orderUpdate->update();

            // update history
            $history = new OrderHistory();
            $history->order_id = $orders->id;
            $history->shipment_status_id = 9;
            $history->user_id = auth()->user()->id;
            $history->note = 'Surat Jalan Telah Diterbitkan';
            $history->created_at = now();
            $history->updated_at = now();
            $history->save();

            return redirect()->route('logistik')->with('success', 'Berhasil')->with('description', 'Surat Jalan Telah Diterbitkan');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('logistik.loading.barang')->withErrors([
                'Error' => 'Gagal Menerbitkan Surat Jalan',
            ]);

        }

    }

    public function viewSJ($id)
    {
        $sj = SuratJalan::find($id);

        // decode base64 to pdf
        $pdf = base64_decode($sj->doc_surjal);

        // return response

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="surat_jalan.pdf"');
            
    }


}


