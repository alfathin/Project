@extends('layout.main')

@section('container')
    <section>
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                    class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <h1 class="mb-4">Register</h1>
                    <form method="POST">
                        @csrf
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" required class="form-control form-control-lg" />
                        <label class="form-label" for="form1Example13">Email address</label>
                        </div>

                        <!-- Username input -->
                        <div class="form-outline mb-4">
                            <input type="username" id="username" required name="username" class="form-control form-control-lg" />
                            <label class="form-label" for="form1Example13">Username</label>
                        </div>

                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="name" id="name" name="name" required class="form-control form-control-lg" />
                            <label class="form-label" for="form1Example13">Name</label>
                        </div>
            
                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="password" name="password" required class="form-control form-control-lg" />
                        <label class="form-label" for="form1Example23">Password</label>
                        </div>
            
                        <div class="d-flex justify-content-around align-items-center mb-4">
                        <p>You have an account? <a href="/">Login</a></p>
                        </div>
            
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-success btn-lg btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
  </section>
@endsection