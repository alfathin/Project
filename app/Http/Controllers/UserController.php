<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function loginView() {
        return view('login', [
            'titlePage' => 'Login'
        ]);
    }
    public function adminView()
    {
        $totalProducts = Product::count();
        $totalOrders = Transaction::count();
        $totalCustomers = User::where('role_id', 1)->count();

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

        return view('admin.dasboard', [
            'titlePage' => 'Admin',
            'product' => $totalProducts,
            'order' => $totalOrders,
            'costumer' => $totalCustomers,
            'chart' => $monthlyTransactions,
            'total_price' => $monthlyPrices2,
            'week' => $dates,
            'total_item' => $monthlyItems4,
            'week2' => $dates2,
        ]);
    }

    public function registerView() {
        return view('register', [
            'titlePage' => 'Register'
        ]);
    }

    public function homeView() {

        $topProducts = Product::with('ratings')
        ->withCount(['ratings as average_rating' => function ($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0)'));
        }])
        ->orderByDesc('average_rating')
        ->take(3)
        ->get();
        return view('home', [
            'titlePage' => 'Home',
            'products' => $topProducts
        ]);
    }

    public function login(Request $request) : RedirectResponse {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role_id == 1) {
                return redirect()->intended('home');
            } elseif ($user->role_id == 2) {
                return redirect()->intended('admin');
            }
        }
        return back()->with('Error' , 'Username or Password is Incorrect!');
    }

    public function logout(Request $request) : RedirectResponse {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request) : RedirectResponse {
        $request->validate([
            'email' => ['required', 'unique:users'],
            'username' => ['required', 'unique:users'],
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->image = 'img/profile.png';
        $user->role_id = 1;

        $user->save();
        
        return redirect('/')->with('success', 'Registrasion Was Successfull! Please Login');
    }

    public function viewProfile() {
        $totalTransactions = Transaction::where('user_id', Auth::id())->count();
        $totalAmount = Transaction::where('user_id', Auth::id())->sum('price');
        $totalProducts = Transaction::where('user_id', Auth::id())->sum('total_item');
        return view('profile',[
            'titlePage' => auth()->user()->name,
            'transaction' => $totalTransactions,
            'amount' => $totalAmount,
            'product' => $totalProducts
        ]);
    }

    public function editProfile(Request $request, $id) : RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;


        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image)); // Menghapus file dari direktori publik
            }

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('user'), $imageName);

            $user->image = 'user/' . $imageName;
        } else {
            unset($request->image);
        }

        $user->save();
        return redirect('/profile')->with('success', 'Profile was updated successfully!');
    }

    public function adminViewCostumer() {
        return view('admin.costumer', [
            'titlePage' => 'Costumer',
            'costumer' => User::where('role_id', 1)->get()
        ]);
    }
}
