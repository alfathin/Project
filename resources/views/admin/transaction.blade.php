@extends('layout.admin.main')

@section('container')
    
    <table class="table table-striped mb-5">
        <thead>
            <tr>
                <th scope="col" class="text-center">Order ID</th>
                <th scope="col" class="text-center">Costumer</th>
                <th scope="col" class="text-center">Product</th>
                <th scope="col" class="text-center">Price</th>
                <th scope="col" class="text-center">Total Item</th>
                <th scope="col" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction as $order)    
                <tr>
                    <td class="text-center">{{ $order->order_id }}</td>
                    <td class="text-center">{{ $order->user->name }}</td>
                    <td class="text-center">{{ $order->product_name }}</td>
                    <td class="text-center">Rp. {{ number_format($order->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $order->total_item }}</td>
                    <td class="text-center">
                        @if ($order->status == 'Unpaid')
                            <span class="badge bg-danger">{{ $order->status }}</span>
                        @elseif ($order->status == 'Paid')
                            <span class="badge bg-success">{{ $order->status }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection