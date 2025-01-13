<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prices;
use App\Models\ProductCategories;
use App\Models\ProductColors;
use App\Models\ProductMaterials;
use App\Models\ProductProductSizes;
use App\Models\ProductProductCategories;
use App\Models\ProductProductColors;
use App\Models\ProductProductMaterials;
use App\Models\ProductProductTypes;
use App\Models\Products;
use App\Models\ProductSizes;
use App\Models\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('ProductType', 'ProductImage')->orderBy('id', 'DESC')->get();
        return view('admin.products.index', with([
            'products' => $products,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategories::all();
        $colors = ProductColors::all();
        $sizes = ProductSizes::all();
        $materials = ProductMaterials::all();
        $product_types = ProductTypes::all();
        return view('admin.products.create', with([
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'materials' => $materials,
            'product_types' => $product_types,
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = $request->validate([
            'name' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'meta_image' => 'required',
            'category' => 'required',
            'type' => 'required',
            'color' => 'required',
            'size' => 'required',
            'material' => 'required',
            'description' => 'required',
        ]);

        $price = Prices::where('type_id', $request->input('type'))->pluck('price')->first();

        try {
            DB::beginTransaction();

            $product = Products::create([
                'categories_id' => $request->category,
                'colors_id' => $request->color,
                'sizes_id' => $request->size,
                'materials_id' => $request->material,
                'type_id' => $request->type,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_image' => $request->input('meta_image'),
                'price' => $price,
                'whatsapp' => 0,
                'telegram' => 0,
                'website' => 0,
                'promotion' => 0,
            ]);

            ProductProductCategories::create([
                'products_id' => $product->id,
                'product_categories_id' => $product->categories_id,
            ]);

            ProductProductColors::create([
                'products_id' => $product->id,
                'product_colors_id' => $product->colors_id,
            ]);

            ProductProductSizes::create([
                'products_id' => $product->id,
                'product_sizes_id' => $product->sizes_id,
            ]);

            ProductProductMaterials::create([
                'products_id' => $product->id,
                'product_materials_id' => $product->materials_id,
            ]);

            ProductProductTypes::create([
                'products_id' => $product->id,
                'product_types_id' => $product->type_id,
            ]);


            if (!$product) {
                DB::rollBack();

                return back()->with('error', 'Something went wrong while saving user data');
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'product stored successfully');
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
        $product = Products::with(
            'ProductType',
            'Material',
            'Color',
            'Size',
            'Category',
            'ProductImage',
        )
            ->where('id', $id)
            ->orderBy('id', 'DESC')
            ->first();

        return view('admin.products.show', with([
            'product' => $product,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Products::find($id);

        $category = ProductCategories::where('id', $products->categories_id)->first();
        $categories = ProductCategories::all();

        $color = ProductColors::where('id', $products->colors_id)->first();
        $colors = ProductColors::all();

        $size = ProductSizes::where('id', $products->sizes_id)->first();
        $sizes = ProductSizes::all();

        $material = ProductMaterials::where('id', $products->materials_id)->first();
        $materials = ProductMaterials::all();

        $product_type = ProductTypes::where('id', $products->type_id)->first();
        $product_types = ProductTypes::all();


        return view('admin.products.edit', with([
            'category' => $category,
            'categories' => $categories,
            'color' => $color,
            'colors' => $colors,
            'size' => $size,
            'sizes' => $sizes,
            'material' => $material,
            'materials' => $materials,
            'product_type' => $product_type,
            'product_types' => $product_types,
            'products' => $products,
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = $request->validate([
            'name' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'meta_image' => '',
            'category' => '',
            'type' => '',
            'color' => '',
            'size' => '',
            'material' => '',
            'description' => '',
            'whatsapp' => '',
            'telegram' => '',
            'website' => '',
            'promotion' => '',
        ]);

        try {
            DB::beginTransaction();

            $product = Products::find($id);
            if ($product) {
                $product->categories_id = $request->category;
                $product->colors_id = $request->color;
                $product->sizes_id = $request->size;
                $product->materials_id = $request->material;
                $product->type_id = $request->type;
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->meta_title = $request->input('meta_title');
                $product->meta_description = $request->input('meta_description');
                $product->meta_keywords = $request->input('meta_keywords');
                $product->meta_image = $request->input('meta_image');
                $product->whatsapp = !empty($request->whatsapp) ? 1 : 0;
                $product->telegram = !empty($request->telegram) ? 1 : 0;
                $product->website = !empty($request->website) ? 1 : 0;
                $product->promotion = !empty($request->promotion) ? 1 : 0;

                $product->save();
            } else {
                dd("Product not found");
            }



            ProductProductCategories::where('products_id', $id)->delete();
            ProductProductCategories::create([
                'products_id' => $product->id,
                'product_categories_id' => $product->categories_id,
            ]);

            ProductProductColors::where('products_id', $id)->delete();
            ProductProductColors::create([
                'products_id' => $product->id,
                'product_colors_id' => $product->colors_id,
            ]);

            ProductProductSizes::where('products_id', $id)->delete();
            ProductProductSizes::create([
                'products_id' => $product->id,
                'product_sizes_id' => $product->sizes_id,
            ]);

            ProductProductMaterials::where('products_id', $id)->delete();
            ProductProductMaterials::create([
                'products_id' => $product->id,
                'product_materials_id' => $product->materials_id,
            ]);

            ProductProductTypes::where('products_id', $id)->delete();
            ProductProductTypes::create([
                'products_id' => $product->id,
                'product_types_id' => $request->input('type'),
            ]);


            if (!$product) {
                DB::rollBack();

                return back()->with('error', 'Something went wrong while saving user data');
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'product updated successfully');
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
        $product = Products::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('message', 'product Deleted Successfully.');
    }
}
