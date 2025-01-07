<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public  function dashboard()
    {
        $numberOfCategories = Category::count();
        $numberOfProducts = Product::count();
        $numberOfActiveProducts =  Product::where('status', 1)->count();

        return view('admin.dashboard', compact('numberOfCategories', 'numberOfProducts', 'numberOfActiveProducts'));
    }
}
