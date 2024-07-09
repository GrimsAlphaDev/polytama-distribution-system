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
    <link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">
@endsection

@section('title')
    Driver Polytama Indramayu
@endsection

@section('content')
    @include('components.notification')

    @include('driver.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">

        @include('driver.components.header')

        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                @if ($order != null)
                    <div class="row g-4 mb-4">
                        <!-- Table -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">Active Shipment</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="order_number" class="fw-bold form-label d-block">Dipesan Oleh :
                                                </label>
                                                <label for="customer"
                                                    class="form-label">{{ $order->customer->name }}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="order_number" class="fw-bold form-label d-block">Nomor Pesanan :
                                                </label>
                                                <label for="order_number"
                                                    class="form-label">{{ $order->order_number }}</label>
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
                                                <label for="order_date" class="fw-bold form-label d-block">Keterangan
                                                    Pesanan :
                                                </label>
                                                <label for="order_date" class="form-label">
                                                    {{ $order->keterangan }}
                                                </label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="order_date" class="fw-bold form-label d-block">Total Berat
                                                    Produk
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
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end">
                                                @if ($order->shipment_status_id == 3)
                                                    <button type="submit" class="btn btn-primary ms-2 text-white"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">Update Status
                                                        Menuju Warehouse</button>
                                                @endif
                                                @if ($order->shipment_status_id == 4)
                                                    <button type="submit" class="btn btn-primary ms-2 text-white"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">Update
                                                        Status Telah Tiba Di Warehouse</button>
                                                @endif
                                                @if ($order->shipment_status_id == 9)
                                                    <button type="submit" class="btn btn-primary ms-2 text-white me-2"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">Update
                                                        Status Sedang Mengirim Produk</button>
                                                @endif
                                                @if ($order->shipment_status_id == 10)
                                                    <button type="submit" class="btn btn-primary ms-2 text-white me-2"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">Selesaikan Pesanan</button>
                                                @endif
                                                @if ($order->shipment_status_id > 8)
                                                    <form action="{{ route('viewSJ', $order->surat_jalan->id) }}"
                                                        id="suratJalanForm" target="_blank" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success text-white"
                                                            id="buttonView">View Surat Jalan</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <!-- Table -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">Timeline Shipment</div>
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center mt-70 mb-70">
                                        <!-- Section: Timeline -->
                                        <section class="py-2">
                                            <ul class="timeline">

                                                @foreach ($histories as $hs)
                                                    <li class="timeline-item mb-5">
                                                        <h5 class="fw-bold">{{ $hs->shipmentStatus->name }}</h5>
                                                        <p>
                                                            {{ $hs->created_at->format('d F Y H:i:s') }}
                                                        </p>
                                                        <p class="text-muted">
                                                            Note : {{ $hs->note }}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </section>
                                        <!-- Section: Timeline -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Status Pesanan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('updateStatusOrder', $order->id) }}" method="POST">
                                    <div class="modal-body">
                                        @csrf

                                        @if ($order->shipment_status_id == 3)
                                            <input type="hidden" name="shipment_status_id" value="4">

                                            <div class="mb-3">
                                                {{-- label muted --}}
                                                <label class="form-label d-block text-muted">Status Shipment Akan Dirubah
                                                    Menjadi 'Driver
                                                    Menuju Gudang'</label>
                                            </div>
                                        @elseif ($order->shipment_status_id == 4)
                                            <input type="hidden" name="shipment_status_id" value="5">

                                            <div class="mb-3">
                                                {{-- label muted --}}
                                                <label class="form-label d-block text-muted">Status Shipment Akan Dirubah
                                                    Menjadi 'Truck
                                                    Tiba di Gudang'</label>
                                            </div>
                                        @elseif ($order->shipment_status_id == 9)
                                            <input type="hidden" name="shipment_status_id" value="10">

                                            <div class="mb-3">
                                                {{-- label muted --}}
                                                <label class="form-label d-block text-muted">Status Shipment Akan Dirubah
                                                    Menjadi 'Driver Mengirim Pesanan'</label>
                                            </div>
                                        @elseif ($order->shipment_status_id == 10)
                                            <input type="hidden" name="shipment_status_id" value="11">

                                            <div class="mb-3">
                                                {{-- label muted --}}
                                                <label class="form-label d-block text-muted">Status Shipment Akan Dirubah
                                                    Menjadi 'Pesanan Telah Selesai'</label>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="order_number" class="fw-bold form-label d-block">Nomor Pesanan :
                                            </label>
                                            <label for="order_number"
                                                class="form-label">{{ $order->order_number }}</label>
                                        </div>

                                        <div class="mb-3">
                                            <label for="keterangan" class="fw-bold form-label d-block">Keterangan :
                                            </label>
                                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Keterangan"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="submitAccept">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row g-4 mb-4">
                        <div class="card">
                            <h4 class="text-center fw-bold" style="margin: 20px ">Tidak Ada Active Shipment</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @include('marketing.components.footer')
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

            document.getElementById('suratJalanForm').addEventListener('submit', function(event) {
                // Tampilkan animasi loading
                loaderContainer.style.display = 'block';

                // Tambahkan sedikit penundaan untuk memastikan tab baru terbuka sebelum menghentikan animasi
                setTimeout(function() {
                    loaderContainer.style.display = 'none';
                }, 1000); // 1 detik penundaan
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
