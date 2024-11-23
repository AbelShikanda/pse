<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\newComment;
use App\Models\Admin;
use App\Models\Comments;
use App\Models\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comments::with('user', 'blog')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.comments.index', with([
            'comments' => $comments,
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
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);
    
        Ratings::create([
            'user_id' => auth()->id(),
            'blog_id' => $request->blog_id,
            'rating' => $request->rating,
        ]);
    
        return back()->with('message', 'Thank you for your comment');
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
