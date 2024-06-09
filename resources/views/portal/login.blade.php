@extends('templates.layouts')

@section('title')
    LOGIN
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <style>
        body {
            background-image: url("{{ asset('assets/img/login-bg.jpg') }}");
            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                    <li><span>{{ $error }}</span></li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <form action="{{ route('signIn') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <h1>Login</h1>
                                    <p class="text-body-secondary">Sign In to your account</p>
                                    <div class="input-group mb-3"><span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input class="form-control" type="text" placeholder="NIK" name="nik" required min="6" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                        maxlength="6"
                                        >
                                    </div>
                                    <div class="input-group mb-4"><span class="input-group-text">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>
                                        <input class="form-control" type="password" placeholder="Password" name="password" required min="6">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Login</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="card col-md-5 text-white bg-primary py-5">
                            <div class="card-body text-center">
                                <div>
                                    <h2>PORPOLDIST</h2>
                                    <p>Silahkan login untuk mengakses sistem terintegrasi proses distribusi produk PT
                                        Polytama Propindo Indramayu
                                    </p>
                                    <a class="btn btn-lg btn-outline-light mt-3" type="button"
                                        href="{{ route('landing-page') }}">Go Back To Landing Page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
