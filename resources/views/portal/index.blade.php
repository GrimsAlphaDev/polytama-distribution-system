<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Polytama Distribution</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" />
    <!-- ===============================================--><!--    Favicons--><!-- ===============================================-->
    <meta name="theme-color" content="#ffffff">
    <!-- ===============================================--><!--    Stylesheets--><!-- ===============================================-->
    <link rel="stylesheet" href="{{ asset('assets/portal/vendors/swiper/swiper-bundle.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="{{ asset('assets/portal/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/portal/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('assets/portal/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: auto;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .alert-show {
            opacity: 1;
        }
    </style>
</head>

<body>
    @include('components.loading')

    @include('components.notification')

    <main class="main" id="top">
        @include('components.notification')
        <div class="content">
            <nav class="navbar navbar-expand-md fixed-top" id="navbar"
                data-navbar-soft-on-scroll="data-navbar-soft-on-scroll">
                <div class="container-fluid px-0"><a href="/">
                        <h1 class="navbar-brand w-75 d-md-none">PORPOLDIST</h1>
                    </a><a class="navbar-brand fw-bold d-none d-md-block" href="/">PORTAL POLYTAMA
                        DISTRIBUTION</a><a class="btn btn-primary btn-sm ms-md-x1 mt-lg-0 order-md-1 ms-auto"
                        href="{{ route('login') }}" id="loginButton">LOGIN
                    </a><button class="navbar-toggler border-0 pe-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false"
                        aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse justify-content-md-end" id="navbar-content"
                        data-navbar-collapse="data-navbar-collapse">
                        <ul class="navbar-nav gap-md-2 gap-lg-3 pt-x1 pb-1 pt-md-0 pb-md-0"
                            data-navbar-nav="data-navbar-nav">
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#home">Home</a></li>
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#sekilas">Sekilas Polytama</a></li>
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#product">Product</a></li>
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#aboutus">About Us</a></li>
                            <li class="nav-item"> <a class="nav-link lh-xl" href="#contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div data-bs-target="#navbar" data-bs-spy="scroll" tabindex="0">
                <section class="hero-section overflow-hidden position-relative z-0 mb-4 mb-lg-0" id="home">
                    <div class="hero-background">
                        <div class="container">
                            <div class="row gy-4 gy-md-8 pt-9 pt-lg-0">
                                <div class="col-lg-6 text-center text-lg-start">
                                    <h1 class="fs-6 fs-lg-5 text-white fw-bold mb-2 mb-lg-x1 lh-base mt-3 mt-lg-0">
                                        INDUSTRI PETROKIMIA DI INDONESIA </h1>
                                    <p class="fs-8 text-white mb-3 mb-lg-4 lh-lg" style="text-align: justify">
                                        Polytama berperan penting sebagai ujung tombak dalam upaya Pemerintah Indonesia
                                        untuk memajukan industri petrokimia nasional dalam memenuhi kebutuhan domestik
                                        dan mengurangi ketergantungan impor. Pemerintah Indonesia meyakini bahwa
                                        pengembangan industri petrokimia sebagai bagian dari industri hulu akan
                                        mendorong pertumbuhan industri hilir yang akhirnya secara umum mampu mendukung
                                        industri manufaktur yang kuat.
                                    </p>

                                </div>
                                <div class="col-lg-6 position-lg-relative">
                                    <div class="position-lg-absolute z-1 text-center"><img class="img-fluid chat-image"
                                            src="assets/img/hero-bg.png" alt="" />
                                        <div class="position-absolute dots d-none d-md-block"> <img
                                                class="img-fluid w-50 w-lg-75"
                                                src="assets/portal/img/illustrations/Dots.webp" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 z-1"><img class="wave mb-md-n2"
                            src="assets/portal/img/illustrations/Wave.svg" alt="" />
                        <div class="bg-white py-2 py-md-5"></div>
                    </div>
                </section>

                <section class="container mb-8 mb-lg-13" id="sekilas">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6 col-xl-5 order-lg-1"><img class="img-fluid rounded shadow-lg"
                                src="{{ asset('assets/img/tower.jpg') }}" alt="Tower" /></div>
                        <div class="col-12 col-lg-6 col-xl-7">
                            <div class="row justify-content-center justify-content-lg-start">
                                <div class="col-sm-10 col-md-8 col-lg-11">
                                    <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-center text-lg-start"> Sekilas Polytama
                                    </h2>
                                    <p class="fs-8 mb-4 mb-lg-5 lh-lg text-center text-lg-start fw-normal"
                                        style="text-align: justify !important">
                                        PT Polytama Propindo didirikan pada tahun 1993 sebagai produsen resin
                                        polipropilena (resin PP) yang signifikan di Indonesia. Polytama adalah salah
                                        satu perusahaan petrokimia terkemuka dan berkembang yang menyediakan resin PP di
                                        Indonesia dengan merek Masplene®. Pada tahun 2017, Polytama meluncurkan inovasi
                                        produk terbarunya yaitu granule. Pabrik Polytama terletak di Desa Limbangan,
                                        Kecamatan Juntinyuat, Indramayu, Jawa Barat. Polytama merupakan perusahaan di
                                        industri Polypropylene yang memanfaatkan teknologi LyondellBasell, salah satu
                                        teknologi pengolahan terbaik di dunia.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="experience position-relative overflow-hidden" id="product">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="position-relative z-1 text-center mb-8 mb-lg-9 video-player-paused"
                                    data-video-player-container="data-video-player-container"><video
                                        class="w-100 h-100 rounded-4"
                                        src="{{ asset('assets/video/comp-profile.mp4') }}"
                                        poster="{{ asset('assets/img/polytama1.jpg') }}" type="video/mp4"
                                        data-video-player="data-video-player"></video>
                                    <div class="overlay position-absolute top-0 bottom-0 start-0 end-0 rounded-4 bg-1100 object-cover"
                                        data-overlay="data-overlay"> </div><button
                                        class="btn play-button position-absolute justify-content-center align-items-center bg-white rounded-circle cursor-pointer"
                                        data-play-button="data-play-button"> <img class="play-icon w-25"
                                            src="assets/portal/img/illustrations/play-solid.svg" alt=""
                                            data-play-icon="data-play-icon" /><img class="pause-icon w-25"
                                            src="assets/portal/img/illustrations/pause-solid.svg" alt=""
                                            data-pause-icon="data-pause-icon" /></button>
                                    <div class="position-absolute dots d-none d-sm-block"><img class="img-fluid w-100"
                                            src="assets/portal/img/illustrations/Dots.webp" alt="" /></div>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-7">
                                <h2 class="fs-4 fs-lg-3 fw-bold text-center text-white mb-2 lh-sm">Quality Product</h2>
                                <h4 class="fs-6 fs-lg-5 fw-normal text-center text-white mb-5 mb-lg-8">Leveraging
                                    Capacity to Produce High Quality Products</h4>
                            </div>
                            <div class="col-12">
                                <div class="row gy-4 g-md-3 pb-8 pb-lg-11 px-1">
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="{{ asset('assets/img/pellet.png') }}" alt="Pellet Plastik"
                                            class="img-fluid w-25" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">Pelet Plastik</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0"
                                                style="text-align: justify">
                                                Pellet merupakan bahan polipropilen murni yang telah melalui proses
                                                peleburan dalam ekstrusi Pellet. Dengan merek dagang Masplene®. Produk
                                                polipropilena Polytama telah mendapatkan Sertifikat Halal dari Majelis
                                                Ulama Indonesia (MUI)
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="{{ asset('assets/img/granule.png') }}" alt="Granul"
                                            class="img-fluid w-25" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">Granul</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0"
                                                style="text-align: justify">
                                                Granule merupakan produk inovatif Polytama yang telah dipasarkan sejak
                                                Agustus 2017. Granule merupakan partikel yang terbentuk sebagai hasil
                                                pembesaran progresif dari partikel primer. Produk inovasi ini merupakan
                                                langkah terobosan Polytama untuk menciptakan segmen pasar tersendiri di
                                                tengah persaingan pasar polipropilena di Indonesia
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img
                                            src="{{ asset('assets/img/pasar-dist.png') }}" alt="Distribusi"
                                            class="img-fluid w-25" />
                                        <div>
                                            <h5 class="fs-8 text-white lh-lg fw-bold">Pasar dan Distribusi</h5>
                                            <p class="text-white text-opacity-50 lh-xl mb-0"
                                                style="text-align: justify">Polytama fokus pada pasar dalam negeri yang
                                                mengalami kelebihan permintaan, di mana secara tidak langsung kami
                                                membantu pemerintah dalam penghematan devisa untuk impor produk
                                                polipropilena. Dengan merek dagang Masplene® yang telah dikenal baik
                                                oleh pelanggan dalam waktu yang panjang, Polytama terus berkembang untuk
                                                memenuhi kebutuhan resin polipropilena di Indonesia.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-0 start-0 end-0">
                        <div class="bg-white py-3 py-md-9 py-xl-10"> </div><img class="wave"
                            src="assets/portal/img/illustrations/Wave_2.svg" alt="" />
                    </div>
                </section>

                <section class="bg-1100" id="aboutus">
                    <div class="container">
                        <div class="row py-8 py-md-10 py-lg-11">
                            <div class="col-lg-6">
                                <div class="row justify-content-center justify-content-lg-start">
                                    <div class="col-md-8 col-lg-12 col-xl-11">
                                        <h2
                                            class="text-white fs-4 fs-lg-3 lh-sm mb-2 text-center text-lg-start fw-bold">
                                            About Us</h2>
                                        <p
                                            class="fs-8 text-white text-opacity-65 mb-4 mb-md-6 mb-lg-7 lh-lg mb-6 mb-lg-7 text-center text-lg-justify">
                                            Polytama berkomitmen menerapkan prinsip-prinsip GCG untuk memastikan
                                            Perusahaan memiliki daya saing yang kuat dan prospek pertumbuhan yang
                                            berkelanjutan. Tata kelola perusahaan dilakukan antara lain dengan
                                            memaksimalkan nilai Perusahaan melalui peningkatan prinsip transparansi,
                                            akuntabilitas, dapat dipercaya, bertanggung jawab, dan adil. Polytama terus
                                            berupaya mengelola Perusahaan secara profesional, transparan, dan efisien,
                                            memberdayakan berbagai fungsi dan meningkatkan independensi organ
                                            Perusahaan, yang kesemuanya dilandasi oleh prinsip moral yang tinggi dan
                                            sepenuhnya mematuhi peraturan perundang-undangan yang berlaku.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="accordion mt-lg-4 ps-3 pe-x1 bg-white" id="accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading1"><button
                                                class="accordion-button fs-8 lh-lg fw-bold pt-x1 pb-2" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse1"
                                                aria-expand="true" aria-controls="collapse1"
                                                data-accordion-button="data-accordion-button">Visi</button></h2>
                                        <div class="accordion-collapse collapse show" id="collapse1"
                                            data-bs-parent="#accordion">
                                            <div class="accordion-body lh-xl pt-0 pb-x1 text-justify">
                                                Menjadi pemimpin produser polipropilena di Indonesia yang tangguh dan
                                                dinamis, yang berorientasi kepada kepuasan pelanggan dan pemangku
                                                kepentingan.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading2"><button
                                                class="accordion-button fs-8 lh-lg fw-bold pt-x1 pb-2 collapsed"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse2"
                                                aria-expand="false" aria-controls="collapse2"
                                                data-accordion-button="data-accordion-button">Misi</button></h2>
                                        <div class="accordion-collapse collapse" id="collapse2"
                                            data-bs-parent="#accordion">
                                            <div class="accordion-body lh-xl pt-0 pb-x1">
                                                <ul class="text-justify">
                                                    <li>
                                                        Menjadi pemimpin pasar produk polipropilena di Indonesia
                                                    </li>
                                                    <li>
                                                        Memanfaatkan kapasitas saat ini hingga tingkat optimal untuk
                                                        barang produksi bernilai lebih baik atau lebih tinggi
                                                    </li>
                                                    <li>
                                                        Mendorong efisiensi dan tepat guna dalam proses, SDM dan biaya
                                                    </li>
                                                    <li>
                                                        Modernisasi proses, teknologi, mesin, dan fasilitas yang
                                                        berkesinambungan di seluruh aspek operasi perusahaan
                                                    </li>
                                                    <li>
                                                        Mengembangkan teknologi yang dimiliki dalam manufaktur polimer
                                                        terutama untuk proses, resep dan penyesuaian produk sesuai
                                                        kebutuhan pasar
                                                    </li>
                                                    <li>
                                                        Melaksanakan sistem multi-sumber terutama untuk bahan baku utama
                                                        demi meningkatkan keandalan perusahaan
                                                    </li>
                                                    <li>
                                                        Membangun sistem sumber daya manusia yang berkelanjutan untuk
                                                        menjamin kelangsungan perusahaan di masa mendatang dan
                                                        kesejahteraan para karyawan
                                                    </li>
                                                    <li>
                                                        Mengadopsi sistem manajemen integrasi di atas standar ISO 9001 –
                                                        ISO 14001 – ISO 22000 – ISO 45001
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading3"><button
                                                class="accordion-button fs-8 lh-lg fw-bold pt-x1 pb-2 collapsed"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse3"
                                                aria-expand="false" aria-controls="collapse3"
                                                data-accordion-button="data-accordion-button">Nilai - Nilai
                                                Utama</button></h2>
                                        <div class="accordion-collapse collapse" id="collapse3"
                                            data-bs-parent="#accordion">
                                            <div class="accordion-body lh-xl pt-0 pb-x1">
                                                Nilai - nilai utama kami terdiri dari :
                                                <ul class="text-justify">
                                                    <li class="fw-bold">
                                                        Safety
                                                    </li>
                                                    <p>
                                                        Membudayakan lingkungan kerja yang aman, sehat dan selamat serta
                                                        memberikan kontribusi positif terhadap lingkungan.
                                                    </p>
                                                    <li class="fw-bold">
                                                        Innovation
                                                    </li>
                                                    <p>
                                                        Mengembangkan ide-ide baru melalui pemberdayaan SDM dan
                                                        teknologi yang berkesinambungan.
                                                    </p>
                                                    <li class="fw-bold">
                                                        Accountability
                                                    </li>
                                                    <p>
                                                        Bertanggung jawab terhadap cara dan hasil kerja yang berkualitas
                                                        baik.
                                                    </p>
                                                    <li class="fw-bold">
                                                        Professionalism
                                                    </li>
                                                    <p>
                                                        Bekerja dengan tulus, jujur, dan disiplin serta berkomitmen pada
                                                        pelayanan optimal untuk semua pihak.
                                                    </p>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-300 position-relative z-0" id="contact">
                    <div class="container py-8 py-lg-9">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-6 col-xl-7">
                                <div class="row justify-content-center justify-content-lg-start">
                                    <div class="col-sm-10 col-md-8 col-lg-11">
                                        <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-center text-lg-start mb-3"> Contact
                                            Us
                                        </h2>
                                        <div class="col-12">
                                            <div class="mb-x1 mb-lg-4">
                                                <h5 class="fs-8 fw-bold lh-lg mb-1">Head Office</h5>
                                                <p class="b-0 lh-xl"><i class="bi bi-telephone"></i> Tel : (62-21) 570
                                                    3883</p>
                                                <p class="b-0 lh-xl"><i class="bi bi-telephone"></i> Fax : (62-21) 570
                                                    4689</p>
                                                <p class="b-0 lh-xl"><i class="bi bi-envelope"></i>
                                                    corporatesecretary@polytama.co.id</p>
                                            </div>
                                            <div>
                                                <h5 class="fs-8 fw-bold lh-lg mb-1"> Plant Site</h5>
                                                <p class="b-0 lh-xl"><i class="bi bi-telephone"></i> Tel : (0234) 428
                                                    002</p>
                                                <p class="b-0 lh-xl"><i class="bi bi-telephone"></i> Fax : (0234) 428
                                                    616</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-5 order-lg-1">
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.993273864116!2d108.40030687586999!3d-6.394867462548411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ebf1830a49851%3A0x5703dab99a76373f!2sPT%20Polytama%20Propindo!5e0!3m2!1sid!2sid!4v1717765475734!5m2!1sid!2sid"
                                        style="border:0;" allowfullscreen="false" class="rounded shadow-lg"
                                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 z-n1 d-none d-lg-block"><img
                            src="assets/portal/img/illustrations/Green_dots.svg" alt="" /></div>
                    <div class="position-relative bottom-0 start-0 z-1"><img class="img-fluid w-100"
                            src="assets/portal/img/illustrations/Wave_3.svg" alt="" /></div>
                </section>
            </div><button
                class="btn scroll-to-top text-white rounded-circle d-flex justify-content-center align-items-center bg-primary"
                data-scroll-top="data-scroll-top"><span class="uil uil-angle-up"></span></button>
            <footer class="pt-7 pt-lg-8">
                <div class="container">

                    <div class="row gy-2 py-3 justify-content-center justify-content-md-between">
                        <div class="col-auto ps-0">
                            <p class="text-center text-md-start lh-xl text-1100"> © 2024 Copyright, All Right Reserved,
                                Made by <a class="fw-semi-bold"
                                    href="https://www.linkedin.com/in/haikal-alfandi-61836922a"
                                    target="_blank">Mochammad Haikal Alfandi Subagyo </a>❤️
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <script src="assets/portal/vendors/popper/popper.min.js"></script>
    <script src="assets/portal/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="assets/portal/vendors/is/is.min.js"></script>
    <script src="assets/portal/vendors/countup/countUp.umd.js"></script>
    <script src="assets/portal/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="assets/portal/vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="assets/portal/js/theme.js"></script>

    <script>
        const loaderContainer = document.getElementById('loader-container');
        document.addEventListener("DOMContentLoaded", function() {
            // Hide loader after page is fully loaded
            window.addEventListener("load", function() {
                loaderContainer.style.display = 'none';
            });
        });

        const loginButton = document.getElementById('loginButton');
        loginButton.addEventListener('click', function() {
            loaderContainer.style.display = 'flex'; // Change to 'flex' to center the loader
        });
    </script>

    <script src="{{ asset('assets/js/notification.js') }}"></script>
    <script>
        const loaderContainer = document.getElementById('loader-container');
        document.addEventListener("DOMContentLoaded", function() {
            // Hide loader after page is fully loaded
            window.addEventListener("load", function() {
                loaderContainer.style.display = 'none';
            });
        });

        // trigger loading when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            loaderContainer.style.display = 'flex';
        });
    </script>

</body>

</html>
