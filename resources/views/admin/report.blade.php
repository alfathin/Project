@extends('layout.admin.main')

@section('container')

<div class="row gx-5 row-cols-1 row-cols-md-2">
    <div class="col mb-5 h-100">
        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-moon"></i></div>
        <h2 class="h5">Banyak Pesanan Setiap Bulan</h2>
        <canvas id="myChart"></canvas>
    </div>
    <div class="col mb-5 h-100">
        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-moon"></i></div>
        <h2 class="h5">Pendapatan Setiap Bulan</h2>
        <canvas id="myChart2"></canvas>
    </div>
    <div class="col mb-5 mb-md-0 h-100">
        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-sun"></i></div>
        <h2 class="h5">Banyak Pesanan Setiap Hari</h2>
        <canvas id="myChart3"></canvas>
    </div>
    <div class="col h-100 mb-5">
        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-moon"></i></div>
        <h2 class="h5">Banyak Jajanan Yang Dibeli Perbulan</h2>
        <canvas id="myChart4"></canvas>
    </div>
    <div class="col h-100">
        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-sun"></i></div>
        <h2 class="h5">Banyak Jajanan Yang Dibeli Perminggu</h2>
        <canvas id="myChart5"></canvas>
    </div>
</div>

<div>
    <canvas id="myChart"></canvas>
</div>
    

<script>
    const ctx = document.getElementById('myChart');
    const monthlyTransactions = @json(array_values($chart));
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Total Transactions peer Mounth',
                data: monthlyTransactions,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx2 = document.getElementById('myChart2');

    // Data total harga transaksi per bulan yang diambil dari controller
    const monthlyPrices2 = @json(array_values($total_price));

    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Total Price of Transactions',
                data: monthlyPrices2,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx3 = document.getElementById('myChart3');

    // Data total harga transaksi per minggu yang diambil dari controller
    const weeklyPrices = @json(array_values($week));
    const weeks = @json(array_keys($week));

    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: weeks.map(week => `${week}`), // Label minggu
            datasets: [{
                label: 'Total Transactions peer Day',
                data: weeklyPrices,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx4 = document.getElementById('myChart4');

    // Data total item yang terjual per bulan yang diambil dari controller
    const monthlyItems4 = @json(array_values($total_item));

    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Total Jajanan Sold',
                data: monthlyItems4,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx5 = document.getElementById('myChart5');

    // Data total harga transaksi per minggu yang diambil dari controller
    const weeklyPrices5 = @json(array_values($week2));
    const weeks5 = @json(array_keys($week2));

    new Chart(ctx5, {
        type: 'bar',
        data: {
            labels: weeks5.map(week2 => `${week2}`), // Label minggu
            datasets: [{
                label: 'Total Jajanan peer Day',
                data: weeklyPrices5,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>
@endsection
