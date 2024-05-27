<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function adminCategoriesView() {
        return view('admin.categories', [
            'titlePage' => 'Categories',
            'categories' => Category::all()
        ]);
    }

    public function adminAddCategory(Request $request) : RedirectResponse {
        $request->validate([
            'category_name' => ['required', 'unique:categories']
        ]);
        
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();

        return redirect('/admin/categories')->with('success', 'Create Category was Successfull!!');
    }

    public function adminDeleteCategory($id) : RedirectResponse {
        $category = Category::findOrFail($id);
        if ($category) {
            $category->delete();
            return redirect('/admin/categories')->with('success', 'Category Was Deleted!!');
        }
        return redirect('/admin/categories')->with('Error', 'Category Not Found!!');
    }

    public function adminEditCategory(Request $request ,$id) : RedirectResponse {
        $request->validate([
            'category_name' => ['required', 'unique:categories']
        ]);
        $category = Category::findOrFail($id);
        if ($category) {
            $category->category_name = $request->category_name;
            $category->save();
            return redirect('/admin/categories')->with('success', 'Category Was Updated!!');
        }
        return redirect('/admin/categories')->with('Error', 'Category Not Found!!');
    }
}
