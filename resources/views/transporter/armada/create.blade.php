@extends('templates.layouts')

@section('styles')
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/marketing/package/simplebar/dist/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/marketing/css/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/marketing/css/style.css') }}" rel="stylesheet">
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

                <div class="row g-4 mb-4">
                    <!-- Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Tambah Armada</div>
                            <div class="card-body">
                                <form action="{{ route('armada.insert') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama kendaraan</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Tipe Kendaraan</label>
                                        <select class="form-control" id="type" name="type" data-allow-clear="true"
                                            data-placeholder="Pilih Type" required>
                                            <option disabled selected>-- Pilih Tipe Kendaraan --</option>
                                            <option value="Tronton" {{ old('type') == 'Tronton' ? 'selected' : '' }}>Tronton</option>
                                            <option value="Gandeng" {{ old('type') == 'Gandeng' ? 'selected' : '' }}>Gandeng</option>
                                            <option value="Engkel" {{ old('type') == 'Engkel' ? 'selected' : '' }}>Engkel</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Merk Kendaraan</label>
                                        <input type="text" class="form-control" id="brand" name="brand"
                                            value="{{ old('brand') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="year" class="form-label">Tahun Pembuatan</label>
                                        <input type="number" class="form-control" id="year" name="year" min="1900"
                                            value="{{ old('year') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="condition" class="form-label">Kondisi Kendaraan</label>
                                        <select class="form-control" id="condition" name="condition" data-allow-clear="true"
                                            data-placeholder="Pilih Kondisi" required>
                                            <option disabled selected>-- Pilih Kondisi Kendaraan --</option>
                                            <option value="Baik" {{ old('condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="Rusak" {{ old('condition') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="license_plate" class="form-label">Nomor Polisi</label>
                                        <input type="text" class="form-control" id="license_plate" name="license_plate"
                                            value="{{ old('license_plate') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="max_weight" class="form-label">Berat Maksimum</label>
                                        <input type="number" class="form-control" id="max_weight" name="max_weight" min="1"
                                            value="{{ old('max_weight') }}" required>
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
