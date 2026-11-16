<?php

namespace App\Http\Controllers;

use App\Models\BlogImages;
use App\Models\ProductImages;
use App\Models\Review;
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

        $reviews = Review::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('home', with([
            'images' => $images,
            'blogs' => $blogs,
            'reviews' => $reviews,
        ]));
    }
}
