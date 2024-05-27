@extends('layout.main')

@section('container')

<div class="modal fade" data-bs-backdrop="static" id="modal_form_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_titleE">Edit Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_edit" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                    <div class="mb-3">
                        <img height="100" width="100" id="imageS" src="" alt="">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Chose Product Image :</label>
                        <input class="form-control" type="file" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name : </label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email : </label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username : </label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form_edit" id="save"><i class="fa fa-user"></i> Save changes</button>
            </div>
        </div>
    </div>
</div>

@if(session()->has('success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
@endif

    
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-12 col-xl-4">

        <div class="card bg-light" style="border-radius: 15px;">
          <div class="card-body text-center">
            <div class="mt-3 mb-4">
              <img src="{{ asset(auth()->user()->image) }}"
                class="rounded-circle img-fluid" style="width: 100px;" />
            </div>
            <h4 class="mb-2">{{ auth()->user()->name}}</h4>
            <p class="text-muted mb-4">{{ auth()->user()->email}} | {{ auth()->user()->username}}</p>
            <button  class="btn btn-warning" onclick="editProfile('{{ auth()->user()->id}}', '{{ auth()->user()->name}}', '{{ auth()->user()->email}}', '{{ auth()->user()->username}}', '{{ asset(auth()->user()->image) }}')">Edit</button>
            <div class="d-flex justify-content-between text-center mt-5 mb-2">
              <div>
                <p class="mb-2 h6">{{ $transaction }}</p>
                <p class="text-muted mb-0">Total Pesanan</p>
              </div>
              <div class="px-3">
                <p class="mb-2 h6">Rp. {{ number_format($amount, 0, ',', '.') }}</p>
                <p class="text-muted mb-0">Total Pembelian</p>
              </div>
              <div>
                <p class="mb-2 h6">{{ $product }}</p>
                <p class="text-muted mb-0">Total Jajanan Dibeli</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    function editProfile(id, name, email, username, image) {
        $('#profile_id').val(id);
        $('#name').val(name);
        $('#email').val(email);
        $('#username').val(username);
        $('#imageS').attr('src', image);
        $('#form_edit').attr('action', '/editProfile/' + id);
        $('#modal_form_edit').modal('show');
    }
</script>

@endsection