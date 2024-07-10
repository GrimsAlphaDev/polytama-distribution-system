@extends('templates.layouts')

@section('styles')
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/marketing/package/simplebar/dist/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/marketing/css/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/marketing/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/marketing/package/chartjs/dist/css/coreui-chartjs.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* optimize height and width of mychart on every device */
        @media (max-width: 768px) {
            #myChart {
                height: 300px;
                width: 300px;
            }
        }

        @media (min-width: 768px) {
            #myChart {
                height: 400px;
                width: 400px;
            }
        }
    </style>
@endsection

@section('title')
    Marketing Polytama Indramayu
@endsection

@section('content')
    @include('components.notification')

    @include('marketing.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">

        @include('marketing.components.header')

        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Detail Pesanan Customer</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="order_number" class="fw-bold form-label d-block">Dipesan Oleh :
                                            </label>
                                            <label for="customer" class="form-label">{{ $order->customer->name }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_number" class="fw-bold form-label d-block">Nomor Pesanan :
                                            </label>
                                            <label for="order_number" class="form-label">{{ $order->order_number }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_date" class="fw-bold form-label d-block">Transporter Yang
                                                Dipilih : </label>
                                            <label for="order_date"
                                                class="form-label">{{ $order->transporter->name }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_date" class="fw-bold form-label d-block">Alamat Customer :
                                            </label>
                                            <label for="order_date"
                                                class="form-label">{{ $order->customer->alamat }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_date" class="fw-bold form-label d-block">Driver Yang
                                                Ditugaskan : </label>
                                            @if ($order->driver)
                                                <label for="order_date" class="form-label">
                                                    {{ $order->driver->name }}
                                                </label>
                                            @else
                                                <label for="order_date" class="form-label text-warning">
                                                    Belum ada driver yang ditugaskan
                                                </label>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="armada" class="fw-bold form-label d-block">Armada Yang
                                                Dikerahkan : </label>
                                            @if ($order->armada)
                                                <label for="armada" class="form-label">
                                                    {{ $order->armada->name }}
                                                </label>
                                            @else
                                                <label for="armada" class="form-label text-warning">
                                                    Belum ada armada yang dikerahkan
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="order_date" class="fw-bold form-label d-block">Tanggal Pesanan
                                                Dibuat :
                                            </label>
                                            <label for="order_date" class="form-label">
                                                {{ $order->created_at->format('d F Y') }}
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_date" class="fw-bold form-label d-block">Tanggal Pesanan
                                                Diupdate :
                                            </label>
                                            <label for="order_date" class="form-label">
                                                {{ $order->updated_at->format('d F Y') }}
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_status" class="fw-bold form-label d-block">Status Pesanan
                                                : </label>
                                            <label for="order_status"
                                                class="form-label">{{ $order->shipmentStatus->name }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_date" class="fw-bold form-label d-block">Keterangan Pesanan :
                                            </label>
                                            <label for="order_date" class="form-label">
                                                {{ $order->keterangan }}
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_date" class="fw-bold form-label d-block">Total Berat Produk
                                                Yang Dipesan :
                                            </label>
                                            <label for="order_date" class="form-label">
                                                {{ $totalWeight }} KG
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="text-center">Rincian Product Yang Dipesan</h4>
                                <div class="row">
                                    {{-- table pesanan --}}
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Produk</th>
                                                        <th>Weight</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $key => $detail)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $detail->product->name }}</td>
                                                            <td>{{ $detail->product->weight }} KG</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td id="price{{ $key }}">
                                                                {{ $detail->product->price }}
                                                            </td>
                                                            <td id="subtotal{{ $key }}">
                                                                {{ $detail->total }}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    {{-- total --}}
                                                    <tr>
                                                        <td colspan="5" class="text-end fw-bold">Total</td>
                                                        <td id="total">{{ $total }}</td>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- create 3 button right aligned for back edit and delete --}}
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('order') }}" class="btn btn-secondary">Kembali</a>
                                            <a href="{{ route('order.edit', $order->id) }}"
                                                class="btn btn-primary ms-2">Edit
                                                Pesanan</a>
                                            <form action="{{ route('order.delete', $order->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger ms-2 text-white"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus
                                                    Pesanan</button>
                                            </form>
                                            @if ($order->shipment_status_id > 8)
                                                <form action="{{ route('viewSJ', $order->surat_jalan->id) }}"
                                                    id="suratJalanForm" target="_blank" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success text-white ms-2"
                                                        id="buttonView">View Surat Jalan</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('marketing.components.footer')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- necessary plugins-->
    <script src="{{ asset('assets/marketing/package/coreui/dist/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/simplebar/dist/simplebar.min.js') }}"></script>
    <script>
        const header = document.querySelector('header.header');
        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });

        // page onload
        document.addEventListener('DOMContentLoaded', () => {
            // get price and subtotal
            const price = document.querySelectorAll('[id^=price]');
            const subtotal = document.querySelectorAll('[id^=subtotal]');
            let total = 0;
            subtotal.forEach((element, index) => {
                total += parseInt(element.textContent);
            });

            // format price and subtotal
            price.forEach((element, index) => {
                element.textContent = parseInt(element.textContent).toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
                subtotal[index].textContent = parseInt(subtotal[index].textContent).toLocaleString(
                    'id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
            });



            // format total
            document.getElementById('total').textContent = total.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });


        });
    </script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('assets/marketing/package/chart.js/dist/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/chartjs/dist/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/utils/dist/umd/index.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/main.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/config.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/color-modes.js') }}"></script>
@endsection
