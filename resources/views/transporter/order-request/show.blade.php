@extends('templates.layouts')

@section('styles')
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/marketing/package/simplebar/dist/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/marketing/css/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/marketing/css/style.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('title')
    Marketing Polytama Indramayu
@endsection

@section('content')
    @include('components.notification')

    @include('transporter.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">

        @include('transporter.components.header')

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
                                            <label for="order_status" class="form-label">{{ $order->status }}</label>
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
                                            <a href="{{ route('order-request') }}" class="btn btn-secondary">Kembali</a>
                                            @if ($order->status == 'Menunggu Konfirmasi Transporter')
                                                <button data-bs-toggle="modal" data-bs-target="#reject"
                                                    class="btn btn-danger text-white ms-2">Reject Customer Order</button>
                                                <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    class="btn btn-primary ms-2">Accept Customer Order</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('marketing.components.footer')
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Accept Customer Order</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('order-request.accept', $order->order_number) }}" method="POST"
                                id="modalForm">
                                <div class="modal-body">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="driver_id" class="form-label">Pilih Driver</label>
                                        <select name="driver_id" id="driver_id" required>
                                            <option selected disabled>Pilih Driver</option>
                                            @foreach ($drivers as $driver)
                                                @if ($driver->user->transporter_id == auth()->user()->id)
                                                    <option value="{{ $driver->user_id }}">{{ $driver->user->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="armada_id" class="form-label">Pilih Armada</label>
                                        <select name="armada_id" id="armada_id" required>
                                            <option selected disabled>Pilih Armada</option>
                                            @foreach ($armadas as $armada)
                                                <option value="{{ $armada->id }}">{{ $armada->name }} | Max Load:
                                                    {{ $armada->max_load }}KG</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
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


                <!-- Modal -->
                <div class="modal fade" id="reject" tabindex="-1" aria-labelledby="rejectLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="rejectLabel">Reject Customer Order</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('order-request.reject', $order->order_number) }}" method="POST"
                                id="modalForm">
                                <div class="modal-body">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3" required></textarea>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#driver_id').select2({
                dropdownParent: $('#exampleModal'),
                width: '100%',
                allowClear: true,
                placeholder: 'Pilih Driver'
            });

            $('#armada_id').select2({
                dropdownParent: $('#exampleModal'),
                width: '100%',
                allowClear: true,
                placeholder: 'Pilih Armada'
            });

        });
    </script>
@endsection
