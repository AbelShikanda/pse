<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comments;

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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comments::findOrFail($id);
        $comment->delete();

        return redirect()->route('comment.index')->with('message', 'Comment deleted successfully.');
    }
}
