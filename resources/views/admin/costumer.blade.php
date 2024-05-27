@extends('layout.admin.main')

@section('container')
    <table class="table table-striped mb-5">
        <thead>
            <tr>
            <th scope="col" class="text-center">Image</th>
            <th scope="col" class="text-center">Name</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col" class="text-center">Username</th>
            <th scope="col" class="text-center">Total Transaction</th>
            <th scope="col" class="text-center">Total Buy</th>
            <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($costumer as $user)    
                <tr>
                    <td class="text-center"><img height="100px" width="100px" src="{{ asset($user->image) }}" alt=""></td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">{{ $user->username }}</td>
                    <td class="text-center">{{ $user->transaction()->count() }}</td>
                    <td class="text-center">{{ $user->transaction()->sum('total_item') }}</td>
                    <td class="text-center">Rp. {{ number_format($user->transaction()->sum('price'), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection