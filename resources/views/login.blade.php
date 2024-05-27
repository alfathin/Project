@extends('layout.main')

@section('container')
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                @if(session()->has('success'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
        
                @if(session()->has('Error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        {{ session('Error') }}
                    </div>
                    </div>
                @endif
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                    class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h1 class="mb-4">Login</h1>
                    <form method="POST">
                        @csrf
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                        <input type="username" id="username" required name="username" class="form-control form-control-lg" />
                        <label class="form-label" for="form1Example13">Username</label>
                        </div>
            
                        <!-- Password input -->
                        <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" required class="form-control form-control-lg" />
                        <label class="form-label" for="form1Example23">Password</label>
                        </div>
            
                        <div class="d-flex justify-content-around align-items-center mb-4">
                        <p>You dont have any account? <a href="/register">Register</a></p>
                        </div>
            
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-success btn-lg btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
  </section>
@endsection