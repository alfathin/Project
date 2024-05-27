@extends('layout.admin.main')

@section('container')

<div class="text-end">
    <button type="button" class="btn btn-success mb-5" data-bs-toggle="modal" data-bs-target="#modal_form">
        Add Product
    </button>
</div>
@if(session()->has('success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="dropdown mb-3">
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      Sort By Category
    </button>
    <ul class="dropdown-menu">
        @foreach ($categories as $category)
            <li><a class="dropdown-item" href="/admin/productsCategory/{{ $category->category_name }}">{{ $category->category_name }}</a></li>
        @endforeach
    </ul>
</div>

<div class="modal fade" data-bs-backdrop="static" id="modal_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_title">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Chose Product Image :</label>
                        <input class="form-control" type="file" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="name_product" class="form-label">Name Product : </label>
                        <input type="text" class="form-control" id="product_name" placeholder="Name Product" name="product_name" required>
                    </div>
                    <select class="form-select" required name="category_id" id="category_id" aria-label="Default select example">
                        <option selected>Open this select Category</option>
                        @foreach ($categories as $category)  
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    <div class="mb-3">
                        <label for="price_product" class="form-label">Price : </label>
                        <input type="number" class="form-control" id="price" placeholder="Rp. " name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock_product" class="form-label">Stock : </label>
                        <input type="number" class="form-control" id="stock" placeholder="Stock Product" name="stock" required>    
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form" id="save"><i class="fa fa-user"></i> Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-bs-backdrop="static" id="modal_form_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_titleE">Add Product</h1>
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
                        <input class="form-control" type="file" id="imageE" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="name_product" class="form-label">Name Product : </label>
                        <input type="text" class="form-control" id="product_nameE" placeholder="Name Product" name="product_name" required>
                    </div>
                    <select class="form-select" required name="category_id" id="category_idE" aria-label="Default select example">
                        <option selected>Open this select Category</option>
                        @foreach ($categories as $category)  
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    <div class="mb-3">
                        <label for="price_product" class="form-label">Price : </label>
                        <input type="number" class="form-control" id="priceE" placeholder="Rp. " name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock_product" class="form-label">Stock : </label>
                        <input type="number" class="form-control" id="stockE" placeholder="Stock Product" name="stock" required>    
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" id="descriptionE" name="description" rows="3"></textarea>
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
    
<table class="table table-striped mb-5">
    <thead>
        <tr>
          <th scope="col" class="text-center">Image</th>
          <th scope="col" class="text-center">Product</th>
          <th scope="col" class="text-center">Category</th>
          <th scope="col" class="text-center">Price</th>
          <th scope="col" class="text-center">Stock</th>
          <th scope="col" class="text-center">Description</th>
          <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)    
            <tr>
                <td class="text-center"><img height="100px" width="100px" src="{{ asset($product->image) }}" alt=""></td>
                <td class="text-center">{{ $product->product_name }}</td>
                <td class="text-center">{{ $product->category->category_name }}</td>
                <td class="text-center">Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $product->stock }}</td>
                <td class="text-center">{{ $product->description }}</td>
                <td class="text-end">
                    <button class="btn btn-warning" onclick="editProduct({{ $product->id }}, '{{ $product->product_name }}', '{{ $product->price }}', '{{ $product->stock }}','{{ $product->description }}', '{{ asset($product->image) }}',{{ $product->category->id }})">Edit</button>
                    <button class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            fetch(`/admin/product/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        }
        location.reload();
    }

    function editProduct(id, name, price, stock, desc, img, category) {
        $('#modal_titleE').text('Edit Product');
        $('#product_id').val(id);
        $('#product_nameE').val(name);
        $('#priceE').val(price);
        $('#stockE').val(stock);
        $('#descriptionE').val(desc);
        $('#imageS').attr('src', img);
        $('#category_idE').val(category);
        $('#form_edit').attr('action', '/admin/productEdit/' + id);
        $('#modal_form_edit').modal('show');
    }
</script>

@endsection