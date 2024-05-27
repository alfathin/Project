@extends('layout.main')

@section('style')
    <link rel="stylesheet" href="css/style.css">
@endsection

@section('container')

    <section class="mt-5 mb-5">
        <div class="container">
            @include('layout.carousel')
        </div>
    </section>

    <div class="dropdown text-end mb-3">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Sort By Category
        </button>
        <ul class="dropdown-menu">
            @foreach ($categories as $category)
                <li><a class="dropdown-item" href="/productsCategory/{{ $category->category_name }}">{{ $category->category_name }}</a></li>
            @endforeach
        </ul>
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

@endsection