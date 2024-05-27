<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function adminProductsView() {
        return view('admin.products',[
            'titlePage' => 'Products',
            'products' => Product::all(),
            'categories' => Category::all()
        ]);
    }

    public function adminProductsByCategory($name) {
        $category = Category::where('category_name', $name)->first();
        return view('admin.products',[
            'titlePage' => 'Products',
            'products' => $category->product,
            'categories' => Category::all()
        ]);
    }

    public function adminAddProduct(Request $request) : RedirectResponse{
        $request->validate([
            'image' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'product_name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required'
        ]);

        (int) $price = $request->price;
        (int) $stock = $request->stock;
        (int) $category = $request->category_id;
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('product'), $imageName);

        $product = new Product();
        $product->image = 'product/'.$imageName;
        $product->product_name = $request->product_name;
        $product->category_id = $category;
        $product->price = $price;
        $product->stock = $stock;
        $product->description = $request->description;
        $product->save();

        return redirect('/admin/products')->with('success', 'Product was Added!!');

    }

    public function adminDeleteProduct($id) : RedirectResponse {
        $product = Product::findOrFail($id);
        if ($product) {
            $product->delete();
            return redirect('/admin/products')->with('success', 'Product Was Deleted!!');
        }
        return redirect('/admin/products')->with('Error', 'Product Not Found!!');
    }

    public function adminEditProduct(Request $request, $id) : RedirectResponse
    {
        $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = Product::findOrFail($id);

        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;


        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image)); // Menghapus file dari direktori publik
            }

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('product'), $imageName);

            $product->image = 'product/' . $imageName;
        } else {
            unset($request->image);
        }

        $product->save();
        return redirect('/admin/products')->with('success', 'Product was updated successfully!');
    }

    public function productsView() {
        return view('products', [
            'titlePage' => 'Products',
            'products' => Product::all(),
            'categories' => Category::all()
        ]);
    }

    public function productsByCategory($name) {
        $category = Category::where('category_name', $name)->first();
        return view('products',[
            'titlePage' => 'Products',
            'products' => $category->product,
            'categories' => Category::all()
        ]);
    }

    public function productById($id) {
        $product = Product::findOrFail($id);

        return view('product' ,[
            'titlePage' => $product->product_name,
            'product' => $product
        ]);
    }

}
