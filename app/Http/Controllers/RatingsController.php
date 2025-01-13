<?php

namespace App\Http\Controllers;
use App\Mail\newRating;
use App\Models\Admin;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratedItems = Ratings::pluck('products_id')->toArray();

        $productsWithRatings = Products::whereIn('id', $ratedItems)
            ->with(['ratings' => function ($query) {
                $query->select('products_id', DB::raw('AVG(rating) as avg_rating'))
                    ->groupBy('products_id');
            }])
            ->get();
        // dd($productsWithRatings);

        return view('admin.ratings.index', with([
            'productsWithRatings' => $productsWithRatings,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product_id = $request->input('productId');

        $ratings = [];

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'rating_')) {
                $itemId = str_replace('rating_', '', $key);
                $ratings[$itemId] = $value; // Store the rating by item ID
            }
        }

        foreach ($ratings as $itemId => $rating) {
                $rate = Ratings::create([
                    'products_id' => $product_id,
                    'user_id' => Auth::user()->id,
                    'rating' => $rating,
                ]);
        }

        $rate = Ratings::with('user')->find($rate->id);
        $product = Products::with('ProductImage')->find($product_id)->first();

        // Mail::to('printshopeld@gmail.com')
        //     ->send(new newRating($rate, $product));

        return redirect()->back()->with('success', 'Ratings submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
