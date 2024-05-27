<nav class="navbar navbar-expand-lg navbar-light sticky-top bg-warning">
    <div class="container">
      <a class="navbar-brand text-light" href="#">AYANG</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @auth
            <li class="nav-item">
                <a class="nav-link text-white" href="/home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/products">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/invoices">Invoice</a>
            </li>
            @endauth
        </ul>
        <div class="d-flex">
            @auth
            <a href="/carts" style="color: white;" class="me-3 mt-2 ms-2 position-relative">
              <i data-feather="shopping-cart"></i>
              <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle">{{ $cartCount }}</span>
          </a>
            <a class="nav-link text-white mt-2" href="/profile">Welcome, {{ auth()->user()->name }}</a>
            <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger ms-3 me-3">Logout</button>
            </form>
            @endauth

            @unless (Auth::check())
                <a href="/" class="btn btn-primary">Login</a>
            @endunless
        </div>
      </div>
    </div>
  </nav>