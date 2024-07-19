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
    Transporter Polytama Indramayu
@endsection

@section('content')
    @include('components.notification')

    @include('transporter.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">

        @include('transporter.components.header')

        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                <div class="row">
                    <div class="col-6">
                        <div class="card mb-4">
                            <div class="card-header">Chart Kondisi Armada</div>
                            <div class="card-body">
                                <div class="mt-5">
                                    <canvas id="myChart" style="width: 300px !important; height: 300px !important; "></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-6">
                        <div class="card mb-4">
                            <div class="card-header">Chart Status Armada</div>
                            <div class="card-body">
                                <div class="mt-5">
                                    <canvas id="mySecondChart" style="width: 300px !important; height: 300px !important; "></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
        </div>
        @include('transporter.components.footer')
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

    <script>
        
        const armadas = @json($armadas);
        const DATA_COUNT = armadas.length;

        const baik = armadas.filter(armada => armada.condition === 'Baik').length;
        const rusak = armadas.filter(armada => armada.condition === 'Rusak').length;
        const perbaikan = armadas.filter(armada => armada.condition === 'Sedang diperbaiki').length;

        const avaible = armadas.filter(armada => armada.status === 'Available').length;
        const notAvaible = armadas.filter(armada => armada.status === 'Not Available').length;
        const onShip = armadas.filter(armada => armada.status === 'On Shipping').length;

        const labels = ['Baik', 'Rusak', 'Sedang Diperbaiki'];
        const labels2 = ['Available', 'Not Available', 'On Shipping'];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Jumlah Armada',
                data: [baik, rusak, perbaikan],
                backgroundColor: [
                    'rgb(75, 192, 192)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                ]
            }]
        };

        const data2 = {
            labels: labels2,
            datasets: [{
                label: 'Status Armada',
                data: [avaible, notAvaible, onShip],
                backgroundColor: [
                    'rgb(75, 192, 192)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                ]
            }]
        };


        const config = {
            type: 'polarArea',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Kondisi Armada Kendaraan'
                    }
                }
            },
        };

        const config2 = {
            type: 'polarArea',
            data: data2,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Status Armada Kendaraan'
                    }
                }
            },
        };

        var ctx = document.getElementById('myChart').getContext('2d');
        var ctx2 = document.getElementById('mySecondChart').getContext('2d');
        new Chart(ctx, config);
        new Chart(ctx2, config2);
    </script>
@endsection
