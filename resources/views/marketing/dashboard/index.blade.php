@extends('templates.layouts')

@section('styles')
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/marketing/package/simplebar/dist/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/marketing/css/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/marketing/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/marketing/package/chartjs/dist/css/coreui-chartjs.css') }}" rel="stylesheet">
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
                <div class="row mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Data Perolehan Customer</h4>
                        </div>
                        <div class="card-body">
                            <div class="mt-5">
                                <canvas id="myChart" class="w-500 h-100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Data Perolehan Pesanan Customer</h4>
                        </div>
                        <div class="card-body">
                            <div class="mt-5">
                                <canvas id="mySecondChart" class="w-100"></canvas>
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

        // get this year based on global timezone
        const date = new Date();
        const year = date.getFullYear();

        // get customer data
        const customers = @json($customers);
        // count customer data from each month
        const countCustomer = customers.reduce((acc, customer) => {
            const month = new Date(customer.created_at).getMonth();
            acc[month] = acc[month] ? acc[month] + 1 : 1;
            return acc;
        }, {});

        // get customer kota from customer.alamat second (,)
        // const kotaCustomer = customers.map(customer => customer.alamat.split(',')[2].trim());
        // console.log(kotaCustomer)


        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];
        // const datapoints;
        // get datapoints from countCustomer
        const datapoints = labels.map((label, index) => countCustomer[index] || 0);
        const data = {
            labels: labels,
            datasets: [{
                label: 'Customer Baru Polytama',
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
                        text: 'Data Perolehan Customer Baru Polytama Tahun ' + year
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
                            text: 'Jumlah Perolehan Customer'
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            },
        };

    </script>
    
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('assets/marketing/package/chart.js/dist/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/chartjs/dist/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/utils/dist/umd/index.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/main.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/config.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/color-modes.js') }}"></script>

    <script>

        // get customer data
        const orders = @json($orders);
        // count customer data from each month
        const countOrders = orders.reduce((acc, customer) => {
            const month = new Date(customer.created_at).getMonth();
            acc[month] = acc[month] ? acc[month] + 1 : 1;
            return acc;
        }, {});

        const labelSecond = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];

        // get datapoints from countCustomer
        const datapointsSecond = labelSecond.map((label, index) => countOrders[index] || 0);

        const data2 = {
            labels: labels,
            datasets: [{
                label: 'Pesanan Customer',
                data: datapointsSecond,
                borderColor: 'blue',
                fill: false,
                cubicInterpolationMode: 'monotone',
                tension: 0.4
            }]
        };

        // Config block
        const config2 = {
            type: 'line',
            data: data2,
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
                        suggestedMax: 50
                    }
                }
            },
        };


        // Render chart
        window.onload = function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, config);
            var ctx2 = document.getElementById('mySecondChart').getContext('2d');
            new Chart(ctx2, config2);
        };
    </script>
@endsection
