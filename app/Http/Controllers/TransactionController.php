<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function checkoutProduct(Request $request)
    {
        $selectedProducts = json_decode($request->input('selected_products'), true);
        
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = false;
        \Midtrans\Config::$is3ds = true;

        $grossAmount = 0;
        $itemDetails = [];
        $productNames = [];
        $total_item = 0;

        foreach ($selectedProducts as $product) {
            $productData = Product::find($product['id']);

            if ($productData) {
                $quantity = intval($product['quantity']);
                $price = intval($productData->price);

                $itemDetails[] = [
                    'price' => $price,
                    'quantity' => $quantity,
                    'name' => $productData->product_name
                ];
                $grossAmount += $price * $quantity;
                $total_item += $quantity;
                $productNames[] = $productData->product_name;
            }
        }

        $productNamesString = implode(', ', $productNames);

        $params = [
            'transaction_details' => [
                'order_id' => Str::uuid(),
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email
            ],
            // 'enabled_payments' => ['credit_card', 'bca_va', 'bni_va', 'bri_va'],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);


        // $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Authorization' => "Basic $auth",
        // ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $params);

        // $responseBody = json_decode($response->body());
        // if (!isset($responseBody->redirect_url)) {
        //     return response()->json(['error' => 'Invalid response from payment gateway', 'details' => $responseBody], 500);
        // }

        $transaction = new Transaction();
        $transaction->order_id = $params['transaction_details']['order_id'];
        $transaction->status = 'Unpaid';
        $transaction->price = $grossAmount;
        $transaction->total_item = $total_item;
        $transaction->user_id = auth()->user()->id; 
        $transaction->product_name = $productNamesString;
        // $transaction->checkout_link = $responseBody->redirect_url;

        $transaction->save();
        return view('transactions', [
            'titlePage' => 'transaction',
            'snapToken' => $snapToken,
            'item' => $transaction
        ]);
    }

    public function viewTransactions() {
        $userId = auth()->user()->id;

        $transactions = Transaction::where('user_id', $userId)->get();
        return view('transactions', [
            'titlePage' => 'Transactions',
            'transactions' => $transactions
        ]);
    }

    public function afterPayments(Request $request)
    {
        // Mendapatkan server key dari konfigurasi
        $serverKey = config('midtrans.server_key');
        // Membuat hash untuk memverifikasi signature
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        
        // Mengecek apakah signature key cocok
        if ($hashed == $request->signature_key) {
            // Mengecek status transaksi dari request
            if ($request->transaction_status == 'capture') {
                // Mencari transaksi berdasarkan order_id
                $order = Transaction::where('order_id', $request->order_id)->firstOrFail();

                // Memeriksa apakah transaksi ditemukan
                if ($order) {
                    // Mengupdate status transaksi
                    $order->update(['status' => 'Paid']);
                    return response()->json(['message' => 'Transaction updated successfully'], 200);
                } else {
                    // Log pesan kesalahan jika transaksi tidak ditemukan
                    Log::error('Transaction not found: ' . $request->order_id);
                    return response()->json(['error' => 'Transaction not found'], 404);
                }
            }
        } else {
            // Log pesan kesalahan jika signature key tidak valid
            Log::error('Invalid signature key: ' . $request->signature_key);
            return response()->json(['error' => 'Invalid signature key'], 400);
        }
    }

    public function viewInvoices() {
        $userId = auth()->user()->id;
        $transactions = Transaction::where('user_id', $userId)->get();
        return view('invoice', [
            'titlePage' => 'invoice',
            'transactions' => $transactions
        ]);
    }

    public function adminViewTransaction() {
        $transaction = Transaction::all();
        return view('admin.transaction', [
            'titlePage' => 'Transaction',
            'transaction' => $transaction
        ]);
    }

}
