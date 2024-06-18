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

    @include('marketing.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">
        
        @include('marketing.components.header')

        <div class="body flex-grow-1">
            <div class="container-lg px-4">

                <div class="row g-4 mb-4">
                    <!-- Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Customer's Order</div>
                            <div class="card-body">
                                <!-- Add a wrapper around the table for horizontal scrolling -->
                                <div class="table-responsive">
                                    <table id="customersTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Transporter</th>
                                                <th>Driver</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr 
                                                {{-- if status 'Menunggu Konfirmasi Transporter' edit row to yellow --}}
                                                @if ($order->status == 'Menunggu Konfirmasi Transporter')
                                                    class="table-warning"
                                                @elseif ($order->status == 'Pesanan Ditolak oleh Transporter')
                                                    class="table-danger"
                                                @elseif ($order->status == 'Driver dan Armada Telah Dipilih')
                                                    class="table-info"
                                                @endif
                                                >
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $order->order_number }}</td>
                                                    <td>{{ $order->customer->name }}</td>
                                                    <td>{{ $order->transporter->name }}</td>
                                                    {{-- if order->driver->name is null --}}
                                                    <td>{{ $order->driver->name ?? 'Driver Belum Ditunjuk' }}</td>
                                                    <td>{{ $order->keterangan }}</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>
                                                        <div class="d-inline-flex">
                                                            <a href="{{ route('order.edit', $order->id) }}"
                                                                class="btn btn-success btn-sm me-1 text-white">Edit</a>
                                                            <form action="{{ route('order.delete', $order->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm text-white"
                                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data {{ $order->customer->name }}?')">Delete</button>
                                                            </form>
                                                            {{-- detail pesanan --}}
                                                            <a href="{{ route('order.show', $order->id) }}"
                                                                class="btn btn-primary btn-sm ms-1 text-white">Detail</a>
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

                <div class="row g-4 mb-4">
                    <!-- Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-5">
                                    <canvas id="myChart" class="w-100"></canvas>
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

        // get this year based on global timezone
        const date = new Date();
        const year = date.getFullYear();

        // get customer data
        const customers = @json($orders);
        // count customer data from each month
        const countCustomer = customers.reduce((acc, customer) => {
            const month = new Date(customer.created_at).getMonth();
            acc[month] = acc[month] ? acc[month] + 1 : 1;
            return acc;
        }, {});

        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];

        // get datapoints from countCustomer
        const datapoints = labels.map((label, index) => countCustomer[index] || 0);
        const data = {
            labels: labels,
            datasets: [{
                label: 'Pesanan Customer',
                data: datapoints,
                borderColor: 'blue',
                fill: false,
                cubicInterpolationMode: 'monotone',
                tension: 0.4
            }]
        };

        // Config block
        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Data Pesanan Customer Polytama Tahun ' + year
                    },
                },
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pesanan Customer'
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            },
        };


        // Render chart
        window.onload = function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, config);
        };
    </script>
@endsection
