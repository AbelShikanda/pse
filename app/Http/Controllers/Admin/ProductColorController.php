<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductColors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = ProductColors::latest()->get();
        return view('admin.colors.index', with([
            'colors' => $colors, 
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $colors = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        try {
            DB::beginTransaction();
            
            $colors = ProductColors::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ]);

            if (!$colors) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('colors.index')->with(['message', 'color created successfully']);

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
        $colors = ProductColors::find($id);
        return view('admin.colors.edit', with([
            'colors' => $colors,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $colors = $request->validate([
            'name' => '',
            'slug' => '',
        ]);

        try {
            DB::beginTransaction();
            
            $colors = ProductColors::find($id);
            $colors->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ]);

            if (!$colors) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('colors.index')->with(['message', 'color updated successfully']);

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
        
        $color = ProductColors::find($id);
        $color->delete();
        return redirect()->route('colors.index')->with(['message', 'color deleted successfully']);
    }
}
