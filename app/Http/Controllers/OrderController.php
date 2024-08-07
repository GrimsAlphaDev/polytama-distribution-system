<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\OrderHistory;
use App\Models\Product;
use App\Models\SuratJalan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use TCPDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::orderBy('updated_at', 'desc')->get();

        return view('marketing.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name', 'asc')->get();

        $transporters = User::where('role_id', '2')->orderBy('name', 'asc')->get();

        $products = Product::orderBy('name', 'asc')->where('stock', '>', 0)->get();

        return view('marketing.order.create', [
            'customers' => $customers,
            'transporters' => $transporters,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        // dd($request->all());

        // validate request
        $request->validate([
            'order_number' => 'required|unique:orders',
            'customer' => 'required',
            'transporter' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|min:1',
            'subtotal' => 'required|min:1',
            'total' => 'required|min:1',
        ], [
            'order_number.required' => 'Terjadi Kesalahan Pada Order Number, Silahkan Hubungi Admin',
            'order_number.unique' => 'Terjadi Kesalahan Pada Order Number, Silahkan Hubungi Admin',
            'customer.required' => 'Pilih Customer Terlebih Dahulu',
            'transporter.required' => 'Pilih Transporter Terlebih Dahulu',
            'product_id.required' => 'Pilih Product Terlebih Dahulu',
            'quantity.required' => 'Masukkan Jumlah Product Terlebih Dahulu',
            'quantity.min' => 'Jumlah Product Minimal 1',
            'subtotal.required' => 'Terjadi Kesalahan Pada Subtotal, Silahkan Hubungi Admin',
            'subtotal.min' => 'Subtotal Minimal 1',
            'total.required' => 'Terjadi Kesalahan Pada Total, Silahkan Hubungi Admin',
            'total.min' => 'Total Minimal 1',
        ]);

        // if keterangan is null
        if ($request->keterangan == null) {
            $keterangan = '-';
        } else {
            $keterangan = $request->keterangan;
        }

        // mysql start transaction
        DB::beginTransaction();

        // store data
        $order = new Order();
        $order->order_number = $request->order_number;
        $order->customer_id = $request->customer;
        $order->transporter_id = $request->transporter;
        $order->driver_id = null;
        $order->keterangan = $keterangan;
        $order->shipment_status_id = 1;
        $order->save();

        foreach ($request->product_id as $key => $value) {
            $subtotal[$key] = $this->convertCurrencyToInteger($request->subtotal[$key]);
            // convert quantity to integer
            $quantity[$key] = (int) $request->quantity[$key];

            // store order detail
            $order->orderDetails()->create([
                'product_id' => $value,
                'quantity' => $quantity[$key],
                'total' => $subtotal[$key],
            ]);

            // update stock product
            $product = Product::find($value);
            $product->stock = $product->stock - $request->quantity[$key];
            $product->save();
        }

        // get exact date and hour based on jakarta
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        // add to history
        OrderHistory::create([
            'order_id' => $order->id,
            'shipment_status_id' => 1,
            'user_id' => auth()->user()->id,
            'note' => 'Customer Order Created',
            'created_at' => $date,
            'updated_at' => $date,
        ]);



        // mysql commit transaction
        DB::commit();

        return redirect()->route('order')->with('success', 'Berhasil')->with('description', 'Order Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);

        $total = $order->orderDetails->sum('total');

        $surat_jalan = SuratJalan::where('order_id', $id)->first();

        // join order with order with surat jalan
        if ($surat_jalan) {
            $order->surat_jalan = $surat_jalan;
        }

        // count total weight order
        $totalWeight = 0;
        foreach ($order->orderDetails as $orderDetail) {
            $totalWeight += $orderDetail->product->weight * $orderDetail->quantity;
        }

        return view('marketing.order.show', compact('order', 'total', 'totalWeight', 'surat_jalan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $customers = Customer::orderBy('name', 'asc')->get();

        $transporters = User::where('role_id', '2')->orderBy('name', 'asc')->get();

        $products = Product::orderBy('name', 'asc')->where('stock', '>', 0)->get();

        return view('marketing.order.edit', [
            'order' => $order,
            'customers' => $customers,
            'transporters' => $transporters,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        // validate request
        $request->validate([
            'customer' => 'required',
            'transporter' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|min:1',
            'subtotal' => 'required|min:1',
            'total' => 'required|min:1',
        ], [
            'customer.required' => 'Pilih Customer Terlebih Dahulu',
            'transporter.required' => 'Pilih Transporter Terlebih Dahulu',
            'product_id.required' => 'Pilih Product Terlebih Dahulu',
            'quantity.required' => 'Masukkan Jumlah Product Terlebih Dahulu',
            'quantity.min' => 'Jumlah Product Minimal 1',
            'subtotal.required' => 'Terjadi Kesalahan Pada Subtotal, Silahkan Hubungi Admin',
            'subtotal.min' => 'Subtotal Minimal 1',
            'total.required' => 'Terjadi Kesalahan Pada Total, Silahkan Hubungi Admin',
            'total.min' => 'Total Minimal 1',
        ]);

        // if keterangan is null
        if ($request->keterangan == null) {
            $keterangan = '-';
        } else {
            $keterangan = $request->keterangan;
        }

        // mysql start transaction
        DB::beginTransaction();

        // update data
        $order = Order::find($id);
        $order->customer_id = $request->customer;
        $order->transporter_id = $request->transporter;
        $order->driver_id = null;
        $order->keterangan = $keterangan;
        $order->shipment_status_id = 1;
        $order->update();

        // delete order detail
        $order->orderDetails()->delete();

        foreach ($request->product_id as $key => $value) {
            $subtotal[$key] = $this->convertCurrencyToInteger($request->subtotal[$key]);
            // convert quantity to integer
            $quantity[$key] = (int) $request->quantity[$key];

            // store order detail
            $order->orderDetails()->create([
                'product_id' => $value,
                'quantity' => $quantity[$key],
                'total' => $subtotal[$key],
            ]);

            // update stock product
            $product = Product::find($value);
            $product->stock = $product->stock - $request->quantity[$key];
            $product->save();
        }

        // insert to history
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');

        OrderHistory::create([
            'order_id' => $order->id,
            'shipment_status_id' => 1,
            'user_id' => auth()->user()->id,
            'note' => $keterangan . ' - Order Updated',
            'created_at' => $date,
            'updated_at' => $date,
        ]);


        // mysql commit transaction
        DB::commit();

        return redirect()->route('order')->with('success', 'Berhasil')->with('description', 'Order Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        // mysql start transaction
        DB::beginTransaction();

        // delete order detail
        $order->orderDetails()->delete();

        // delete order
        $order->delete();

        // delete order history
        OrderHistory::where('order_id', $id)->delete();

        // mysql commit transaction
        DB::commit();

        return redirect()->route('order')->with('success', 'Berhasil')->with('description', 'Order Berhasil Dihapus');
    }

    public function convertCurrencyToInteger($currencyString)
    {
        // Remove the currency symbol and non-breaking space
        $cleanString = preg_replace('/[^\d,]/', '', $currencyString);

        // Replace the thousand separator (dot) with nothing
        $cleanString = str_replace('.', '', $cleanString);

        // Replace the decimal separator (comma) with nothing
        $cleanString = str_replace(',', '.', $cleanString);

        // Convert the cleaned string to an integer
        $integerValue = (int) $cleanString;

        return $integerValue;
    }

    public function report()
    {

        // get now year jakarta time
        date_default_timezone_set('Asia/Jakarta');
        $year = date('Y');

        $orders = Order::where('shipment_status_id', 11)->whereYear('updated_at', $year)->orderBy('updated_at', 'desc')->get();

        return view('marketing.order.report', compact('orders'));
    }

    public function print()
    {
        // get now year jakarta time
        date_default_timezone_set('Asia/Jakarta');
        $year = date('Y');

        $orders = Order::where('shipment_status_id', 11)->whereYear('updated_at', $year)->orderBy('updated_at', 'desc')->get();

        foreach ($orders as $order) {
            $order->surat_jalan = SuratJalan::where('order_id', $order->id)->first();
        }

        $logoPath = public_path('assets/img/logo-1.png');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator('MIS Departement');

        $pdf->SetAuthor('PT Polytama Propindo');

        $pdf->SetTitle('Laporan Pesanan Pelanggan Tahun 2024');

        $pdf->SetSubject('Laporan Pesanan Pelanggan Tahun 2024');

        $pdf->SetKeywords('TCPDF, PDF, laporan, pesanan, pelanggan');

        $pdf->SetHeaderData($logoPath, PDF_HEADER_LOGO_WIDTH, 'PT POLYTAMA PROPINDO', "Jl. Jendral Sudirman Kav. 10-11 Mid Plaza 2 20 Floor Jakarta 10220\nMain Office Phone : +62 215703883 Fax: +62 21 5704468");

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->setFontSubsetting(true);

        $pdf->SetFont('helvetica', '', 11, '', true);

        $pdf->AddPage();

        // Add logo using Image() method
        $pdf->Image($logoPath, 15, 3, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);
        $pdf->SetY(25);

        $html = '
            <h1 style="text-align: center;">Laporan Pesanan Pelanggan Tahun 2024</h1>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="width: 5%; text-align:center;">No</th>
                        <th style="text-align:center;">Order Number</th>
                        <th style="text-align:center;">Pelanggan</th>
                        <th style="width: 13%; text-align:center;">Transporter</th>
                        <th style="text-align:center;">Supir</th>
                        <th style="width: 20%;">Status Pengiriman</th>
                        <th style="text-align:center;">Dibuat Pada</th>
                        <th style="text-align:center;">Terakhir Diupdate</th>
                    </tr>
                </thead>
                <tbody>
                ';

        $no = 1;
        foreach ($orders as $order) {

            // convert to date time
            $created = date('d-m-Y H:i:s', strtotime($order->created_at));
            $updated = date('d-m-Y H:i:s', strtotime($order->updated_at));

            $html .= '
                    <tr>
                        <td style="width: 5%;">' . $no . '</td>
                        <td>' . $order->order_number . '</td>
                        <td>' . $order->customer->name . '</td>
                        <td style="width: 13%;">' . $order->transporter->name . '</td>
                        <td>' . $order->driver->name . '</td>
                        <td style="width: 20%;">' . $order->shipmentStatus->name . '</td>
                        <td>' . $created . '</td>
                        <td>' . $updated . '</td>
                    </tr>
                ';

            $no++;
        }

        $html .= '
                </tbody>
            </table>
        ';


        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->lastPage();

        $pdf->Output('laporan_pesanan_customer.pdf', 'I');
        dd($pdf);
        exit;
    }
}
