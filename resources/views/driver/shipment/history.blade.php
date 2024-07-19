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
                <div class="row g-4 mb-4">
                    <!-- Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">History Shipment</div>
                            <div class="card-body">
                                <table id="shipmentTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Pemesanan</th>
                                            <th>Customer</th>
                                            <th>Alamat Customer</th>
                                            <th>Status</th>
                                            <th>Terakhir Diperbarui</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $shipment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $shipment->order_number }}</td>
                                                <td>{{ $shipment->customer->name }}</td>
                                                <td>{{ $shipment->customer->alamat }}</td>
                                                <td>{{ $shipment->shipmentStatus->name }}</td>
                                                @php
                                                    $shipment_date = date('d F Y', strtotime($shipment->created_at));
                                                @endphp
                                                <td>{{ $shipment_date }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('marketing.components.footer')
    </div>
@endsection

@section('scripts')
    <!-- necessary plugins-->
    <script src="{{ asset('assets/marketing/package/coreui/dist/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/simplebar/dist/simplebar.min.js') }}"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('assets/marketing/package/chart.js/dist/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/chartjs/dist/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/utils/dist/umd/index.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/main.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/config.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/color-modes.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#shipmentTable').DataTable();
        });
    </script>
@endsection
