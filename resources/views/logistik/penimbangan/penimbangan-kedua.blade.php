@extends('templates.layouts')

@section('styles')
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/marketing/package/simplebar/dist/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/marketing/css/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/marketing/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/marketing/package/chartjs/dist/css/coreui-chartjs.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('title')
    LPPI
@endsection

@section('content')
    @include('components.notification')

    @include('logistik.components.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">

        @include('logistik.components.header')

        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                <div class="row g-4 mb-4">
                    <!-- Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Timbangan Truck Kedua (Dalam Keadaan Loaded)</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="order-request" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Order Number</th>
                                                <th>Customer Name</th>
                                                <th>Driver Assigned</th>
                                                <th>Keterangan</th>
                                                <th>Berat Timbangan Pertama</th>
                                                <th>Berat Kedua</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $or)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $or->order_number }}</td>
                                                    <td>{{ $or->customer->name }}</td>
                                                    <td>{{ $or->driver->name ?? 'Driver Belum Ditunjuk' }}</td>
                                                    <td>{{ $or->keterangan }}</td>
                                                    <td>
                                                        {{ $or->surat_jalan->empty_load_weight ?? 'Data Timbangan Pertama Belum Tersedia' }}
                                                        KG
                                                    </td>
                                                    <td>
                                                        {{ $or->surat_jalan->loaded_weight ?? 'Data Timbangan kedua Belum Tersedia' }}
                                                        KG
                                                    </td>
                                                    <td>{{ $or->shipmentStatus->name }}</td>
                                                    <td>
                                                        <div class="d-inline-flex">
                                                            <a href="{{ route('logistik.show', $or->id) }}"
                                                                class="btn btn-primary btn-sm me-2">Detail</a>
                                                            @if ($or->surat_jalan->loaded_weight == null)
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{ $or->id }}"
                                                                    class="btn btn-sm btn-success text-white ">Tambah
                                                                    Timbangan Kedua</button>
                                                            @else
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#updateModal{{ $or->id }}"
                                                                    class="btn btn-sm btn-info text-white me-2">Update
                                                                    Timbangan</button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- insert Modal -->
                                                <div class="modal fade" id="exampleModal{{ $or->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah
                                                                    Timbangan Kedua</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('logistik.insert.secondW', $or->id) }}"
                                                                method="POST" id="modalForm">
                                                                <div class="modal-body">
                                                                    @csrf

                                                                    <div class="mb-3">
                                                                        <label for="nomor_pesanan"
                                                                            class="fw-bold form-label d-block">Nomor Pesanan
                                                                            :
                                                                        </label>
                                                                        <label for="nomor_pesanan"
                                                                            class="form-label">{{ $or->order_number }}</label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="truck"
                                                                            class="fw-bold form-label d-block">Truck :
                                                                        </label>
                                                                        <label for="truck"
                                                                            class="form-label">{{ $or->armada->name }}</label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="kapasitas"
                                                                            class="fw-bold form-label d-block">Kapasitas Max
                                                                            :
                                                                        </label>
                                                                        <label for="kapasitas"
                                                                            class="form-label">{{ $or->armada->max_load }}</label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="nopol"
                                                                            class="fw-bold form-label d-block">Nomor Polisi
                                                                            :
                                                                        </label>
                                                                        <label for="nopol"
                                                                            class="form-label">{{ $or->armada->license_plate }}</label>
                                                                    </div>


                                                                    <div class="mb-3">
                                                                        <label for="secondW"
                                                                            class="fw-bold form-label d-block">Masukkan
                                                                            Beban Truck Dengan Produk (<span
                                                                                class="fw-bold">KG</span>)</label>
                                                                        <input type="text" class="form-control"
                                                                            name="secondW" min="1"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                                            required>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="submitAccept">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- update Modal -->
                                                <div class="modal fade" id="updateModal{{ $or->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Update
                                                                    Timbangan Kedua</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('logistik.insert.secondW', $or->id) }}"
                                                                method="POST" id="modalForm">
                                                                <div class="modal-body">
                                                                    @csrf

                                                                    <input type="hidden" name="id_surjal"
                                                                        value="{{ $or->surat_jalan->id }}">

                                                                    <div class="mb-3">
                                                                        <label for="nomor_pesanan"
                                                                            class="fw-bold form-label d-block">Nomor
                                                                            Pesanan
                                                                            :
                                                                        </label>
                                                                        <label for="nomor_pesanan"
                                                                            class="form-label">{{ $or->order_number }}</label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="truck"
                                                                            class="fw-bold form-label d-block">Truck :
                                                                        </label>
                                                                        <label for="truck"
                                                                            class="form-label">{{ $or->armada->name }}</label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="kapasitas"
                                                                            class="fw-bold form-label d-block">Kapasitas
                                                                            Max
                                                                            :
                                                                        </label>
                                                                        <label for="kapasitas"
                                                                            class="form-label">{{ $or->armada->max_load }}</label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="nopol"
                                                                            class="fw-bold form-label d-block">Nomor Polisi
                                                                            :
                                                                        </label>
                                                                        <label for="nopol"
                                                                            class="form-label">{{ $or->armada->license_plate }}</label>
                                                                    </div>


                                                                    <div class="mb-3">
                                                                        <label for="secondW"
                                                                            class="fw-bold form-label d-block">Masukkan
                                                                            Beban Truck Dengan Produk (<span
                                                                                class="fw-bold">KG</span>)</label>
                                                                        <input type="text" class="form-control"
                                                                            name="secondW" min="1"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                                            required
                                                                            value="{{ $or->surat_jalan->loaded_weight }}">
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        id="submitAccept">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
        @include('logistik.components.footer')
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#order-request').DataTable();
        });
    </script>
@endsection
