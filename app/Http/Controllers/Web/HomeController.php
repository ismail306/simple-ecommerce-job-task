<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\SubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $products = Product::with('options')->orderBy('created_at', 'desc')->get();
        return view('web.home', compact('categories', 'products'));
    }

}
