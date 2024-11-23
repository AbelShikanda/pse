<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prices;
use App\Models\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = Prices::all();
        $type_ids = $prices->pluck('type_id');
        
        // Fetch type names corresponding to the type IDs
        $type_names = ProductTypes::whereIn('id', $type_ids)->pluck('name', 'id');

        // Attach type names to prices
        $prices->each(function($price) use ($type_names) {
            $price->type_name = $type_names[$price->type_id] ?? 'Unknown';  // Handle unknown type
        });

        return view('admin.prices.index', with([
            'prices' => $prices,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prices.create', with([
            'product_types' => ProductTypes::all(),
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prices = $request->validate([
            'types' => 'required | integer | distinct | unique:prices,type_id',
            'price' => 'required',
        ]);

        try {
            DB::beginTransaction();
            
            $prices = Prices::create([
                'type_id' => $request->input('types'),
                'price' => $request->input('price'),
            ]);

            if (!$prices) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('prices.index')->with(['message', 'price created successfully']);

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
        $type = ProductTypes::find($id);
        $types = ProductTypes::all();
        $prices = Prices::find($id);
        return view('admin.prices.edit', with([
            'prices' => $prices,
            'types' => $types,
            'type' => $type,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $prices = $request->validate([
            'types' => '',
            'price' => '',
        ]);

        try {
            DB::beginTransaction();
            
            $prices = Prices::find($id);
            $prices->update([
                'type_id' => $request->input('types'),
                'price' => $request->input('price'),
            ]);

            if (!$prices) {
                DB::rollBack();
                return back()->with(['message', 'something went wrong while saving your data']);
            }

            DB::commit();
            return redirect()->route('prices.index')->with(['message', 'price updated successfully']);

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
        $price = Prices::find($id);
        $price->delete();
        return redirect()->route('prices.index')->with(['message', 'price deleted successfully']);
    }
}
