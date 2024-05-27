<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        $transactions = Transaction::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->get()
        ->pluck('count', 'month')
        ->toArray();
        $monthlyTransactions = array_fill(1, 12, 0);
        foreach ($transactions as $month => $count) {
            $monthlyTransactions[$month] = $count;
        }

        $transactions2 = Transaction::selectRaw('MONTH(created_at) as month, SUM(price) as total_price')
            ->where('status', ['Paid'])
            ->groupBy('month')
            ->get()
            ->pluck('total_price', 'month')
            ->toArray();
        $monthlyPrices2 = array_fill(1, 12, 0);
        foreach ($transactions2 as $month2 => $total_price) {
            $monthlyPrices2[$month2] = $total_price;
        }

        $transactions3 = Transaction::selectRaw('DATE(created_at) as date, COUNT(*) as total_price')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total_price', 'date')
            ->toArray();
        $dates = [];
        $start = Carbon::now()->subDays(6);
        $end = Carbon::now();
        while ($start <= $end) {
            $dates[$start->format('Y-m-d')] = 0;
            $start->addDay();
        }
        foreach ($transactions3 as $date => $total_price2) {
            $dates[$date] = $total_price2;
        }

        $transactions4 = Transaction::selectRaw('MONTH(created_at) as month, SUM(total_item) as total_items')
            ->where('status', ['Paid'])
            ->groupBy('month')
            ->get()
            ->pluck('total_items', 'month')
            ->toArray();
        $monthlyItems4 = array_fill(1, 12, 0);
        foreach ($transactions4 as $month => $total_items4) {
            $monthlyItems4[$month] = $total_items4;
        }

        $transactions5 = Transaction::selectRaw('DATE(created_at) as date, COUNT(*) as total_price')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total_price', 'date')
            ->toArray();
        $dates2 = [];
        $start2 = Carbon::now()->subDays(6);
        $end2 = Carbon::now();
        while ($start2 <= $end2) {
            $dates2[$start2->format('Y-m-d')] = 0;
            $start2->addDay();
        }
        foreach ($transactions5 as $date => $total_price5) {
            $dates2[$date] = $total_price5;
        }

        return view('admin.report', [
            'titlePage' => 'Report',
            'chart' => $monthlyTransactions,
            'total_price' => $monthlyPrices2,
            'week' => $dates,
            'total_item' => $monthlyItems4,
            'week2' => $dates2,
        ]);
    }
}
