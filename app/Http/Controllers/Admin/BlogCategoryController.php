<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogCategories = BlogCategory::latest()->get();
        return view('admin.categories.blogCategories.index', with([
            'blogCategories' => $blogCategories,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.blogCategories.create', with([]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $blogs = BlogCategory::create([
                'name' => $request->input('name'),
            ]);

            if(!$blogs){
                DB::rollBack();

                return back()->with('error', 'Something went wrong while saving blog category data');
            }

            DB::commit();
            return redirect()->route('blog_categories.index')->with('success', 'blog category Stored Successfully.');


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = BlogCategory::find( $id );

		return view( 'admin.categories.blogCategories.edit' )
			->with( 'category', $category );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => '',
            'slug' => '',
        ]);

        try {
            DB::beginTransaction();

            $blogs = BlogCategory::find($id);
            if ($blogs) {
                $blogs->name = $request->name;
                $blogs->slug = $request->slug;
                
                $blogs->save();
            } else {
                dd("category not found");
            }

            if(!$blogs){
                DB::rollBack();

                return back()->with('error', 'Something went wrong while saving blog category data');
            }

            DB::commit();
            return redirect()->route('blog_categories.index')->with('success', 'blog category updated Successfully.');


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = BlogCategory::find($id);
        $category->delete();
        return redirect()->route('blogs_categories.index')->with('message', 'category Deleted Successfully.');
    }
}
