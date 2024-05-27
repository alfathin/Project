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

<table class="table table-striped mb-5 mt-5">
    <thead>
        <tr>
            <th scope="col" class="text-center">Order ID</th>
            <th scope="col" class="text-center">Product</th>
            <th scope="col" class="text-center">Total Item</th>
            <th scope="col" class="text-center">Total</th>
            <th scope="col" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $item)
        <tr>
            <td class="text-center">{{ $item->order_id }}</td>
            <td class="text-center">{{ $item->product_name }}</td>
            <td class="text-center">{{ $item->total_item }}</td>
            <td class="text-center">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
            <td class="text-center">
                @if ($item->status == 'Unpaid')
                    <span class="badge bg-danger">{{ $item->status }}</span>
                @elseif ($item->status == 'Paid')
                    <span class="badge bg-success">{{ $item->status }}</span>
                @else
                    <span class="badge bg-secondary">{{ $item->status }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
