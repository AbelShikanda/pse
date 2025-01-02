<?php

namespace App\Http\Controllers;

use App\Models\BlogImages;
use App\Models\ProductImages;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $images = ProductImages::with('products')
        ->latest()
        ->take(6)
        ->get();
        
        $blogs = BlogImages::with('blogs')
        ->orderBy('id', 'DESC')
        ->take(2)
        ->get();

        // dd($images);
        return view('home', with([
            'images' => $images,
            'blogs' => $blogs,
        ]));
    }

    /**
     * fuction to display items in the homepage.
     *
     * This function does the following:
     * - Step 1
     * - Step 2
     * - Step 3
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function homeDisplay()
    {
        // $products = Products::all()
        // ->latest()
        // ->get()
        // ->take(4);

        // $blogs = Blogs::all()
        // ->latest()
        // ->get()
        // ->take(4);
    }
}
