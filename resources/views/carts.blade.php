@extends('layout.main')

@section('container')
    @if(session()->has('success'))
        <div class="alert alert-success d-flex align-items-center mt-5" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                {{ session('success') }}
            </div>
        </div>
    @endif
    <section class="container d-flex mt-5 mb-5">
        <div class="item-cart w-75">
            <div class="rs shadow p-3 bg-body rounded mb-3 d-flex align-items-center">
                <input class="form-check-input me-2" type="checkbox" name="selectAll" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    <b>Select All</b>
                </label>
            </div>
            @foreach($carts as $item)
                <div class="rs mt-3 shadow p-3 bg-body rounded d-flex align-items-center justify-content-between">
                    <input class="form-check-input me-2 select-item" type="checkbox" name="select" value="{{ $item->id }}">
                    <div class="img img-thumbnail mx-2">
                        <img src="{{ asset($item->product->image) }}" style="width: 200px; height:150px" alt="product">
                    </div>
                    <div style="flex: 1;">
                        <p>{{ $item->product->product_name }}</p>
                        <p class="fw-bolder">Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="quantity">
                        <input type="number" class="form-control quantity-input" value="{{ $item->quantity }}" min="1" data-price="{{ $item->product->price }}">
                    </div>
                    <div>
                        <form action="/deleteCart" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" value="{{ $item->id }}" name="id">
                            <button style="border: none; background: none;"><i data-feather="trash-2" style="color:red;"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="summary w-25 shadow p-3 bg-body rounded ms-3">
            <div class="detail-summary">
                <h4 class="mb-4">Summary</h4>
                <div class="mb-2 item d-flex justify-content-between">
                    <p>Total:  (<span id="jml">0</span>)</p>
                    <p id="harga">Rp. 0</p>
                </div>
                <hr>
            </div>
            <div class="res">
                <div class="resa mb-3 d-flex justify-content-between">
                    <b class="fw-normal">Total Price :</b>
                    <b id="totalHarga">Rp. 0</b>
                </div>
                <form action="/checkout" method="POST">
                    @csrf
                    <input type="hidden" id="jumlah_harga" name="jumlah_harga">
                    <input id="selectedProducts" type="hidden" name="selected_products">
                    <button id="checkoutButton" class="btn btn-warning text-light" style="width:100%" disabled>Checkout</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Get all checkboxes
        var checkboxes = document.querySelectorAll('.select-item');
        var selectAll = document.getElementById('selectAll');

        var selectedProducts = [];
        // Get the summary elements
        var totalItems = document.getElementById('jml');
        var totalHarga = document.getElementById('harga');
        var totalHargaFinal = document.getElementById('totalHarga');
        // Get the checkout button
        var checkoutButton = document.getElementById('checkoutButton');
        var selectedProductsInput = document.getElementById('selectedProducts');

        selectAll.addEventListener('change', function() {
            // Check if the "Select All" checkbox is checked
            if (this.checked) {
                // Check all checkboxes
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = true;
                    let quantityInput = checkbox.parentNode.querySelector('.quantity-input');
                    quantityInput.disabled = true;
                    updateSummary();
                });
            } else {
                // Uncheck all checkboxes
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                    let quantityInput = checkbox.parentNode.querySelector('.quantity-input');
                    quantityInput.disabled = false;
                    updateSummary();
                });
            }
        });

        // Function to update the summary
        // Function to update the summary
        function updateSummary() {
    // Initialize variables
    var totalQuantity = 0;
    var totalHargaValue = 0;
    var hasSelectedProduct = false;
    selectedProducts = []; // Reset the selectedProducts array

    // Loop through all checkboxes
    checkboxes.forEach(function(checkbox) {
        // Check if the checkbox is checked
        if (checkbox.checked) {
            // Get the quantity of the selected item
            var quantityInput = checkbox.parentNode.querySelector('.quantity-input');
            var quantity = parseInt(quantityInput.value);
            var productId = checkbox.value;
            quantityInput.disabled = true;

            // Update the total quantity
            totalQuantity += quantity;

            // Update the total harga
            var price = parseInt(quantityInput.dataset.price);
            totalHargaValue += price * quantity;

            selectedProducts.push({ id: productId, quantity: quantity });
            hasSelectedProduct = true;
        } else {
            let quantityInput = checkbox.parentNode.querySelector('.quantity-input');
            quantityInput.disabled = false;
        }
    });

    // Update the summary
    totalItems.textContent = totalQuantity;
    totalHarga.textContent = 'Rp. ' + totalHargaValue.toLocaleString();
    totalHargaFinal.textContent = 'Rp. ' + totalHargaValue.toLocaleString();

    // Update the hidden inputs
    selectedProductsInput.value = JSON.stringify(selectedProducts);
    document.getElementById('jumlah_harga').value = totalHargaValue;

    // Enable or disable the checkout button
    checkoutButton.disabled = !hasSelectedProduct;
}

        // Update the summary when the checkboxes or quantities change
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', updateSummary);
        });

        // Update the summary when the quantities change
        var quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(function(input) {
            input.addEventListener('input', updateSummary);
        });

        // Enable the checkout button when the page loads
        updateSummary();

        document.getElementById('checkoutButton').addEventListener('click', function() {
            // Call the checkout function
        });

        // console.log(selectedProducts);
        console.log(totalHargaValue);
    </script>
@endsection