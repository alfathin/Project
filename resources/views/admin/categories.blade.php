@extends('layout.admin.main')

@section('container')

    <div class="text-end">
        <button type="button" class="btn btn-success mb-5" data-bs-toggle="modal" data-bs-target="#modal_form">
            Add Category
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
    @if(session()->has('Error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                {{ session('Error') }}
            </div>
        </div>
    @endif


    <div class="modal fade" data-bs-backdrop="static" id="modal_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form" method="POST">
                    @csrf
                        <div class="mb-3">
                            <label for="category_product" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" placeholder="Category Name" name="category_name" required>
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
                    <h1 class="modal-title fs-5" id="modal_title_edit">Edit Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_edit" method="POST">
                    @csrf
                        <div class="mb-3">
                            <label for="category_product" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name_edit" placeholder="Category Name" name="category_name" required>
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
              <th scope="col" class="text-center">Category</th>
              <th scope="col" class="text-center">Products</th>
              <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)    
                <tr>
                    <td class="text-center">{{ $category->category_name }}</td>
                    <td class="text-center">{{ $category->Product()->count() }}</td>
                    <td class="text-end">
                        <button class="btn btn-warning" onclick="editCategory({{ $category->id }}, '{{ $category->category_name }}')">Edit</button>
                        <button class="btn btn-danger" onclick="deleteCategory({{ $category->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function deleteCategory(categoryId) {

            if (confirm('Are you sure you want to delete this Category?')) {
                fetch(`/admin/category/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            location.reload();
            }
        }

        function editCategory(id, name) {
            $('#modal-title-edit').text('Edit Category');
            // $('#id').val(id);
            $('#category_name_edit').val(name);
            $('#form_edit').attr('action', '/admin/categoryEdit/' + id);
            $('#modal_form_edit').modal('show');
        }
    </script>
    
@endsection