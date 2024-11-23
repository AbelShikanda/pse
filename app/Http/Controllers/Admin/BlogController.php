<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogBlogCategories;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->paginate(7);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blogs = $request->validate([
            'category' => 'required',
            'title' => 'required',
            'subtitle' => '',
            'meta_title' =>'',
            'meta_description' =>'',
            'meta_keywords' =>'required',
            'meta_image' =>'required',
            'body' => 'required',
        ]);

        try {
            DB::beginTransaction();
            
            $blogs = Blog::create([
                'title' => $request->title,
                'sub_title' => $request->subtitle,
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_image' => $request->input('meta_image'),
                'body' => $request->body,
                'blog_categories_id' => $request->category,
            ]);

            BlogBlogCategories::create([
                'blogs_id' => $blogs->id,
                'blog_categories_id' => $blogs->blog_categories_id,
            ]);

            if(!$blogs){
                DB::rollBack();

                return back()->with('error', 'Something went wrong while saving blog data');
            }

            DB::commit();
            return redirect()->route('blogs.index')->with('success', 'blog Created Successfully.');


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogs = Blog::where('id', $id)->first();
        $category = BlogCategory::where('id', $blogs->blog_categories_id)->first();

		return view( 'admin.blogs.show', with([
            'blogs' => $blogs,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blogs = Blog::find( $id );
        $category = BlogCategory::find($id);
        $categories = BlogCategory::all();

		return view('admin.blogs.edit', with([
            'blogs' => $blogs,
            'categories' => $categories,
            'category' => $category,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blogs = $request->validate([
            'category' => '',
            'title' => '',
            'subtitle' => '',
            'slug' => '',
            'meta_title' =>'',
            'meta_description' =>'',
            'meta_keywords' =>'',
            'meta_image' =>'',
            'body' => '',
        ]);

        try {
            DB::beginTransaction();

            $blogs = Blog::find($id);
            if ($blogs) {
                $blogs->blog_categories_id = $request->category;
                $blogs->title = $request->title;
                $blogs->sub_title = $request->subtitle;
                $blogs->body = $request->body;
                $blogs->meta_title = $request->input('meta_title');
                $blogs->meta_description = $request->input('meta_description');
                $blogs->meta_keywords = $request->input('meta_keywords');
                $blogs->meta_image = $request->input('meta_image');
                $blogs->slug = $request->slug;
                
                $blogs->save();
            } else {
                dd("Product not found");
            }
            
            BlogBlogCategories::where('blogs_id', $blogs->id)->delete();
            BlogBlogCategories::create([
                'blogs_id' => $blogs->id,
                'blog_categories_id' => $blogs->blog_categories_id,
            ]);

            if(!$blogs){
                DB::rollBack();

                return back()->with('error', 'Something went wrong while saving blogs data');
            }

            DB::commit();
            return redirect()->route('blogs.index')->with('success', 'Blogs Stored Successfully.');


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blogs = Blog::find($id);
        $blogs->delete();
        return redirect()->route('blogs.index');
    }
}
