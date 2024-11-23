<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductMaterials;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Debug\VirtualRequestStack;

class ProductMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productMaterials = ProductMaterials::latest()->get();
        return View('admin.materials.index', with([
            'productMaterials' => $productMaterials,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $materials = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        try {
            DB::beginTransaction();
            
            $materials = ProductMaterials::create([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ]);

            if (!$materials) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('materials.index')->with(['message', 'material created successfully']);

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
        $materials = ProductMaterials::find($id);
        return view('admin.materials.edit', with([
            'materials' => $materials,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $materials = $request->validate([
            'name' => '',
            'slug' => '',
        ]);

        try {
            DB::beginTransaction();
            
            $materials = ProductMaterials::find($id);
            $materials->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
            ]);

            if (!$materials) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('materials.index')->with(['message', 'material updated successfully']);

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
        $material = ProductMaterials::find($id);
        $material->delete();
        return redirect()->route('materials.index')->with(['message', 'material deleted successfully']);
    }
}
