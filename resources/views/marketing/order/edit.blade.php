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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                            <div class="card-header">Edit Pesanan Customer</div>
                            <div class="card-body">
                                <form action="{{ route('order.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="order_number" class="form-label">Order Number</label>
                                        <input type="text" class="form-control" id="order_number" name="order_number"
                                            value="{{ $order->order_number }}" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="customer" class="form-label">Customer</label>
                                        <select class="form-control" id="customer" name="customer" data-allow-clear="true"
                                            data-placeholder="Pilih Customer" required>
                                            <option disabled selected>-- Pilih Customer --</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    @if (old('customer') == $customer->id || $order->customer_id == $customer->id) selected @endif>
                                                    {{ $customer->name }} -
                                                    {{ $customer->alamat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="transporter" class="form-label">Pilih Transporter</label>
                                        <select class="form-control " id="transporter" name="transporter"
                                            data-allow-clear="true" data-placeholder="Pilih Transporter" required>
                                            <option disabled selected>-- Pilih Transporter --</option>
                                            @foreach ($transporters as $transporter)
                                                <option value="{{ $transporter->id }}"
                                                    {{ old('transporter') == $transporter->id || $order->transporter_id == $transporter->id ? 'selected' : '' }}>
                                                    {{ $transporter->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') ? old('keterangan') : $order->keterangan }}</textarea>
                                    </div>

                                    <hr>

                                    <h5 class="mb-3">Produk yang dipesan</h5>

                                    {{-- create table order item --}}
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Subtotal</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-select" name="product_id[]" id="product_id"
                                                        required>
                                                        <option selected disabled>-- Pilih Produk --</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $order->orderDetails->first()->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}</option>
                                                            >{{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" min="1" class="form-control" id="quantity1"
                                                        name="quantity[]" required
                                                        value="{{ $order->orderDetails->first()->quantity }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                                </td>
                                                <td>
                                                    <input type="text" min="1" readonly class="form-control"
                                                        id="price1" name="price[]" required
                                                        value="{{ $order->orderDetails->first()->product->price }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control" id="subtotal1"
                                                        name="subtotal[]" required
                                                        value="{{ $order->orderDetails->first()->total }}">
                                                </td>
                                                <td>
                                                    <button type="button" id="tambahItem"
                                                        class="btn btn-primary">Tambah</button>
                                                </td>
                                            </tr>
                                            <tr class="{{ $order->orderDetails->count() < 2 ? 'd-none' : '' }}"
                                                id="secondRow">
                                                <td>
                                                    <select class="form-select" name="product_id[]" id="product_id1">
                                                        <option selected disabled>-- Pilih Produk --</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                @if ($order->orderDetails->count() >= 2) {{ $order->orderDetails->last()->product_id == $product->id ? 'selected' : '' }}@endif>
                                                                {{ $product->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" min="1" class="form-control" id="quantity2"
                                                        name="quantity[]"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                        value="{{ $order->orderDetails->count() >= 2 ? $order->orderDetails->last()->quantity : '' }}">
                                                </td>
                                                <td>
                                                    <input type="text" min="1" readonly class="form-control"
                                                        id="price2" name="price[]"
                                                        value="{{ ($order->orderDetails->count() >= 2) ? $order->orderDetails->last()->product->price : '' }}">
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control" id="subtotal2"
                                                        name="subtotal[]"
                                                        value="{{  ($order->orderDetails->count() >= 2) ? $order->orderDetails->last()->total : ''}}">
                                                </td>
                                                <td>
                                                    <button type="button" id="hapusItem"
                                                        class="btn btn-danger text-white">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end">Total</td>
                                                <td colspan="2">
                                                    <input type="text" readonly class="form-control" id="total"
                                                        name="total">
                                                </td>
                                        </tfoot>
                                    </table>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const header = document.querySelector('header.header');
        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });

        $(document).ready(function() {
            $('#customer').select2({
                width: '100%',
                placeholder: 'Pilih Customer',
                allowClear: true
            });
            $('#transporter').select2({
                width: '100%',
                placeholder: 'Pilih Transporter',
                allowClear: true
            });
        });

        const products = @json($products);

        // page onload
        $(document).ready(function() {
            // format price1, price2, subtotal1, subtotal2, total
            const price1 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format($('#price1').val());
            $('#price1').val(price1);

            const price2 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format($('#price2').val());
            $('#price2').val(price2);

            const subtotal1 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format($('#subtotal1').val());
            $('#subtotal1').val(subtotal1);

            const subtotal2 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format($('#subtotal2').val());
            $('#subtotal2').val(subtotal2);

            calculateTotal();
        });

        // if product selected, then set price and subtotal
        $('#product_id').on('change', function() {
            const product_id = $(this).val();
            const product = products.find(product => product.id == product_id);
            const price1 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(product.price);
            $('#price1').val(price1);
            $('#quantity1').val(1);
            const subtotal1 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(product.price);
            $('#subtotal1').val(subtotal1);
            calculateTotal();
        });

        $('#product_id1').on('change', function() {
            const product_id = $(this).val();
            const product = products.find(product => product.id == product_id);
            const price2 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(product.price);
            $('#price2').val(price2);
            $('#quantity2').val(1);
            const subtotal2 = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(product.price);
            $('#subtotal2').val(subtotal2);
            calculateTotal();
        });

        // if quantity changed, then set subtotal
        $('#quantity1').on('keyup', function() {
            const quantity = $(this).val();
            const price = $('#price1').val().replace('Rp', '').replace(/\./g, '');
            const pricenoSpace = price.replace(/^\s+/, '');
            const priceNoComma = pricenoSpace.replace(/,/g, '.');
            const countSubtotal = priceNoComma * quantity;
            const subtotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(countSubtotal);
            $('#subtotal1').val(subtotal);
            calculateTotal();
        });

        $('#quantity2').on('keyup', function() {
            const quantity = $(this).val();
            const price = $('#price2').val().replace('Rp', '').replace(/\./g, '');
            const pricenoSpace = price.replace(/^\s+/, '');
            const priceNoComma = pricenoSpace.replace(/,/g, '.');
            const countSubtotal = priceNoComma * quantity;
            const subtotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(countSubtotal);
            $('#subtotal2').val(subtotal);
            calculateTotal();
        });

        // if add item clicked, then add new row
        $('#tambahItem').on('click', function() {
            // #secondrow disable d-none
            $('#secondRow').removeClass('d-none');
            calculateTotal();
        });

        // hapusItem clicked, then remove row
        $('table').on('click', '#hapusItem', function() {
            $('#secondRow').addClass('d-none');
            $('#product_id1').val('');
            $('#quantity2').val('');
            $('#price2').val('');
            $('#subtotal2').val('');
            calculateTotal();
        });

        function calculateTotal() {
            let total = 0;
            $('input[name="subtotal[]"]').each(function() {

                if ($(this).val() == '') {
                    total += 0;
                } else {
                    // remove currency format 
                    const value = $(this).val().replace('Rp', '').replace(/\./g, '');
                    total += parseInt(value);
                }
            });
            const totalFormat = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(total);
            $('#total').val(totalFormat);
        }
    </script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset('assets/marketing/package/chart.js/dist/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/chartjs/dist/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('assets/marketing/package/utils/dist/umd/index.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/main.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/config.js') }}"></script>
    <script src="{{ asset('assets/marketing/js/color-modes.js') }}"></script>
@endsection
