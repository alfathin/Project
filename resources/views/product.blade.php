@extends('layout.main')

@section('style')
    <link rel="stylesheet" href="{{ asset('detail_product.css') }}">
@endsection

@section('container')

    @if(session()->has('success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <section class="py-5">
        <div class="container px-5">
            <h1 class="fw-bolder fs-5 mb-4">Detail Jajanan</h1>
            <div class="card border-0 shadow bg-light rounded-3 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row gx-0">
                        <div class="col-lg-6 col-xl-5 py-lg-5">
                            <div class="p-4 p-md-5">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2">{{ $product->category->category_name }}</div>
                                <div class="h2 fw-bolder">{{ $product->product_name }}</div>
                                <div class="d-flex flex-row user-ratings">
                                    <div class="average-rating mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $product->averageRating())
                                            <i class="fas fa-star" style="color: #FFD700;"></i>
                                        @else
                                            <i class="far fa-star" style="color: #FFD700;"></i>
                                        @endif
                                        @endfor
                                    </div>
                                    <h6 class="text-muted ml-1 ms-2 mt-1">{{ number_format($product->averageRating(), 1) }} / 5</h6>
                                </div>
                                <p>{{ $product->description }}</p>
                                <p>Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                <div class="d-grid d-sm-flex justify-content-sm-center justify-content-xl-start">
                                    <form action="/carts" method="POST" class="mb-2">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary">Add To Cart</button>
                                    </form>
                                    <a href="/products" class="btn btn-secondary ms-3">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-7 d-flex align-items-center justify-content-center">
                            <div class="img-container">
                                <img src="{{ asset($product->image) }}" class="img-fluid" alt="{{ $product->product_name }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="card bg-light mb-5">
            <div class="card-body">
                <h3 class="card-title mb-3">Rate and Comment this Product</h3>
                <!-- Comment form-->
                <form class="mb-4" action="/ratings" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                        <div class="rating">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" />
                            <label for="star{{ $i }}" title="{{ $i }} stars"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                        </div>
                    <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Leave a comment!"></textarea>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
                <!-- Single comment-->
                @foreach($product->ratings as $rating)
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0"><img height="25" width="25" class="rounded-circle" src="{{ asset($rating->user->image) }}" alt="..." /></div>
                    <div class="ms-3">
                        <div class="fw-bold">{{ $rating->user->name }} <div>
                            @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating->rating)
                                <i class="fas fa-star" style="color: #FFD700;"></i>
                            @else
                                <i class="far fa-star" style="color: #FFD700;"></i>
                            @endif
                            @endfor
                        </div></div>
                        {{ $rating->comment }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>             
@endsection