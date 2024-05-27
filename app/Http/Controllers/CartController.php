<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cartsView() {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cart_items = $cart->items()->with('product')->get();
        return view('carts', [
            'titlePage' => 'Cart',
            'carts' => $cart_items
        ]);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();
        if($cartItem) {
            $cartItem->quantity += 1;
        } else {
            $cartItem = new CartItem([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        $cartItem->save();
        return redirect('/carts')->with('success', 'Product Was Added To Cart!');
    }

    public function deleteCart(Request $request)
    {
        $cartItem = CartItem::findOrFail($request->id);
        $cartItem->delete();
        return back()->with('success', 'Cart Item was Successfully Deleted!');
    }

    
}
