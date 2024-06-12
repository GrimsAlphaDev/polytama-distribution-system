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
                            <div class="card-header">Edit Customer Polytama</div>
                            <div class="card-body">
                                <form action="{{ route('customer.update', $customer->id) }}"  method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Customer</label>
                                        <input type="text" class="form-control" id="name" name="name" required min="3" value="{{ (old('name')  ? old('name') : $customer->name) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required value="{{ (old('email')  ? old('email') : $customer->email) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" value="{{ (old('phone')  ? old('phone') : $customer->no_telp) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="city" class="form-label">Kota</label>
                                        <input type="text" class="form-control" id="city" name="city" required value="{{ (old('city')  ? old('city') : $customer->kota) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Alamat</label> 
                                        <span class="text-muted">(Format Alamat : Nama Perusahaan, Jalan Kota Kode Pos )</span>
                                        <textarea class="form-control" id="address" name="address" required rows="3">{{ (old('address')  ? old('address') : $customer->alamat) }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button> 
                                </form>

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
@endsection
