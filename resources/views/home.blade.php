@extends('layout.main')

@section('style')
    <link rel="stylesheet" href="css/style.css">
@endsection

@section('home')  

    <header class="bg-warning py-5">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        <h1 class="display-5 fw-bolder text-secondary-subtle mb-2">Selamat Datang di Ayang (Ayo Jajan Guys)</h1>
                        <p class="lead fw-normal text-body-tertiary mb-4">Ayang adalah solusi terbaik untuk memenuhi hasrat ngemilmu. Kami menawarkan berbagai macam jajanan lezat yang siap memanjakan lidahmu. Mulai dari camilan tradisional hingga kudapan kekinian, semuanya ada di sini. Yuk, jajan bareng kami dan temukan kenikmatan dalam setiap gigitan!</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Kelebihan Ayang</a>
                                <a class="btn btn-outline-light btn-lg px-4" href="#Favorite">Jajanan Favorit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="img/navbarbrand.png" alt="Logo Company" /></div>
                </div>
            </div>
    </header>


    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h2 class="fw-bolder mb-0">Kenikmatan Jajanan di Setiap Gigitan</h2>
                </div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <h2 class="h5">Pilihan Jajanan Berkualitas</h2>
                            <p class="mb-0">Kami hanya menyediakan jajanan dengan kualitas terbaik. Setiap produk dipilih dengan teliti untuk memastikan kepuasan Anda.</p>
                        </div>
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                            <h2 class="h5">Varian Rasa yang Menggoda</h2>
                            <p class="mb-0">Nikmati berbagai macam rasa jajanan yang menggoda selera, dari manis hingga gurih, semua tersedia untuk memanjakan lidah Anda.</p>
                        </div>
                        <div class="col mb-5 mb-md-0 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h2 class="h5">Kemasan Higienis</h2>
                            <p class="mb-0">Kami memastikan setiap jajanan dikemas dengan standar higienis tinggi, sehingga Anda bisa menikmati camilan dengan tenang dan nyaman.</p>
                        </div>
                        <div class="col h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-star"></i>
                            </div>
                            <h2 class="h5">Jajanan Favorit Semua Orang</h2>
                            <p class="mb-0">Kami menawarkan jajanan yang disukai oleh semua kalangan. Temukan favorit Anda di antara pilihan jajanan kami yang beragam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="py-5 bg-light">
        <div class="container px-5 my-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-10 col-xl-7">
                    <div class="text-center">
                        <div class="fs-4 mb-4 fst-italic">"Ayang adalah tempat terbaik untuk menemukan berbagai jajanan favorit saya. Pelayanannya cepat dan jajanan selalu dikemas dengan rapi dan higienis. Saya selalu puas dengan setiap pesanan!"</div>
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="rounded-circle me-3" height="25px" width="25px" src="img/profile.png" alt="..." />
                            <div class="fw-bold">
                                Alfathin
                                <span class="fw-bold text-primary mx-1">/</span>
                                Developer
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <section class="py-5" id="Favorite">
        <div class="container px-5 my-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="text-center">
                        <h2 class="fw-bolder">Jajanan Rating Tertinggi</h2>
                        <p class="lead fw-normal text-muted mb-5">Tiga Rekomendasi Jajanan Dengan Rating Tertinggi Yang Di Rating Oleh Pelanggan</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $item)    
                <div class="col-md-4">
                    <div class="height d-flex justify-content-center align-items-center">
                        <div class="card p-3">
                            <div class="d-flex justify-content-between align-items-center ">
                                <div class="mt-2">
                                    <h4 class="text-uppercase text-body-tertiary">Ayang</h4>
                                    <div class="mt-5">
                                        <h5 class="text-uppercase mb-0 text-body-tertiary">{{ $item->category->category_name }}</h5>
                                        <h1 class="main-heading text-black mt-0">{{ $item->product_name }}</h1>
                                        <div class="d-flex flex-row user-ratings">
                                            <div class="average-rating mb-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $item->averageRating())
                                                    <i class="fas fa-star" style="color: #FFD700;"></i>
                                                @else
                                                    <i class="far fa-star" style="color: #FFD700;"></i>
                                                @endif
                                                @endfor
                                            </div>
                                            <h6 class="text-muted ml-1 ms-2 mt-1">{{ number_format($item->averageRating(), 1) }} / 5</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="image">
                                    <img src="{{ asset($item->image) }}" width="200">
                                </div>
                            </div>
                            <p>Rp. {{ number_format($item->price, 0, ',', '.') }}</p>
                            <a href="/product/{{ $item->id }}" class="btn btn-warning text-light">Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection