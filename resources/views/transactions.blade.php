@extends('layout.main')

@section('headJs')
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

@section('container')
@if(session()->has('success'))
<div class="alert alert-success d-flex align-items-center mt-5" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
        {{ session('success') }}
    </div>
</div>
@endif

<table class="table table-striped mb-5 mt-5">
    <thead>
        <tr>
            <th scope="col" class="text-center">Order ID</th>
            <th scope="col" class="text-center">Product</th>
            <th scope="col" class="text-center">Total Item</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Total</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($transactions as $item) --}}
        <tr>
            <td class="text-center">{{ $item->order_id }}</td>
            <td class="text-center">{{ $item->product_name }}</td>
            <td class="text-center">{{ $item->total_item }}</td>
            <td class="text-center">{{ $item->status }}</td>
            <td class="text-center">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
            <td class="text-end">
                <button id="pay-button" class="btn btn-primary">Pay!</button>
            </td>
        </tr>
        {{-- @endforeach --}}
    </tbody>
</table>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            var snapToken = '{{ $snapToken }}';
            if (!snapToken) {
                alert('Snap token is missing.');
                return;
            }

            window.snap.pay(snapToken, {
                onSuccess: function (result) {
                    alert("Payment success!");
                    console.log(result);
                    // Implement your own success action here
                },
                onPending: function (result) {
                    alert("Waiting for your payment!");
                    console.log(result);
                    // Implement your own pending action here
                },
                onError: function (result) {
                    alert("Payment failed!");
                    console.log(result);
                    // Implement your own error action here
                },
                onClose: function () {
                    alert('You closed the popup without finishing the payment');
                }
            });
        });
    });
</script>
@endsection
