<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ReviewMiddleware;
use App\Models\Review;
use App\Models\ReviewToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function review_tokens_index()
    {
        $review_tokens = ReviewToken::latest()->get();

        return view('admin.reviewTokens.index', with([
            'review_tokens' => $review_tokens,
        ]));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function review_index()
    {
        $reviews = Review::latest()->get();

        return view('admin.review.index', with([
            'reviews' => $reviews,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Retrieve token from URL or session
        $token = $request->query('token') ?? session('review_token');

        if (!$token) {
            return redirect()->route('home')->with('error', 'Token required to access this page.');
        }

        // Find the token in the database
        $reviewToken = ReviewToken::where('token', $token)->first();

        // Check if the token exists, is not used, and has not expired
        if (!$reviewToken || $reviewToken->is_used || ($reviewToken->expires_at && $reviewToken->expires_at->isPast())) {
            return redirect()->route('home')->with('error', 'Invalid or expired token.');
        }

        // Store valid token in session
        session(['review_token' => $token]);

        $pageTitle = 'Review Me';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '/login', 'label' => 'login'],
            ['url' => '/review/create', 'label' => 'review']
        ];

        return view('reviews.create', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'token' => $token,
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'token' => 'required|string|exists:review_tokens,token',
        ]);

        $token = session('review_token');

        // Check if the token exists and is valid
        $reviewToken = ReviewToken::where('token', $token)->first();

        if (!$reviewToken || $reviewToken->is_used) {
            return redirect('/')->with('error', 'Invalid or used review token.');
        }

        // Prepare review data
        $reviewData = [
            'token' => $request->input('token'),
            'review' => $request->input('review'),
            'rating' => $request->input('rating'),
            'user_id' => auth()->id(),
        ];

        if (!auth()->check()) {
            $reviewData['token'] = $token;  // Store token for guests
        }

        // Create the review
        Review::create($reviewData);

        // Mark the token as used
        $reviewToken->update(['is_used' => true]);

        // Remove token from session
        session()->forget('review_token');
        $reviewToken->delete();

        return redirect('/')->with('message', 'Review submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function review_show(string $id)
    {
        $review = Review::where('id', $id)->first();

        return view('admin.review.show', with([
            'review' => $review,
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $review = Review::findOrFail($id);
    //     return response()->json($review);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $review = Review::findOrFail($id);
    //     $review->delete();
    //     return response()->json(['message' => 'Review deleted successfully!']);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function review_destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()
            ->route('review.index')
            ->with([
                'message' => 'Review deleted successfully!',
            ]);
    }
}
