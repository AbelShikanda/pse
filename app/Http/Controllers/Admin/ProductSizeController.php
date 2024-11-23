<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = ProductSizes::latest()->get();
        return view('admin.sizes.index', with([
            'sizes' => $sizes,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sizes = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        try {
            DB::beginTransaction();
            
            $sizes = ProductSizes::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ]);

            if (!$sizes) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('sizes.index')->with(['message', 'size created successfully']);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSizes $productSizes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sizes = ProductSizes::find($id);
        return view('admin.sizes.edit', with([
            'sizes' => $sizes,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sizes = $request->validate([
            'name' => '',
            'slug' => '',
        ]);

        try {
            DB::beginTransaction();
            
            $sizes = ProductSizes::find($id);
            $sizes->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ]);

            if (!$sizes) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('sizes.index')->with(['message', 'size updated successfully']);

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
        $size = ProductSizes::find($id);
        $size->delete();
        return redirect()->route('sizes.index')->with(['message', 'size deleted successfully']);
    }
}
