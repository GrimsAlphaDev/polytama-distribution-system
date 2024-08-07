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

    @include('transporter.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">

        @include('transporter.components.header')

        <div class="body flex-grow-1">
            <div class="container-lg px-4">

                <div class="row g-4 mb-4">
                    <!-- Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Data Armada</div>
                            <div class="card-body">
                                <!-- Add a wrapper around the table for horizontal scrolling -->
                                <div class="table-responsive">
                                    <table id="customersTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kendaraan</th>
                                                <th>Tipe Kendaraan</th>
                                                <th>Brand</th>
                                                <th>Tahun Pembuatan</th>
                                                <th>Kondisi Kendaraan</th>
                                                <th>Plat Nomor</th>
                                                <th>Muatan Maksimal</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($armadas as $armada)
                                                <tr
                                                    @if ($armada->status == 'Available')
                                                        class="table-success" 
                                                    @elseif ($armada->status == 'Not Available')
                                                        class="table-danger"
                                                    @elseif ($armada->status == "On Shipping")
                                                        class="table-warning"
                                                    @endif>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $armada->name }}</td>
                                                    <td>{{ $armada->brand }}</td>
                                                    <td>{{ $armada->type }}</td>
                                                    <td>{{ $armada->year }}</td>
                                                    <td>
                                                        {{ $armada->condition }}</td>
                                                    <td>{{ $armada->license_plate }}</td>
                                                    <td>{{ $armada->max_load }} <span class="fw-bold">KG</span></td>
                                                    <td>{{ $armada->status }}</td>
                                                    <td>
                                                        <div class="d-inline-flex">
                                                            <a href="{{ route('armada.edit', $armada->id) }}"
                                                                class="btn btn-success btn-sm me-1 text-white">Edit</a>
                                                            <form action="{{ route('armada.delete', $armada->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm text-white"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data kendaraan {{ $armada->name }} ?')">Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
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
    </script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('assets/marketing/package/chart.js/dist/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/chartjs/dist/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/utils/dist/umd/index.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/main.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/config.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/color-modes.js') }}"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#customersTable').DataTable();
        });

    </script>
@endsection
