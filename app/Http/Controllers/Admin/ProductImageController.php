<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\newPost;
use App\Models\ProductImages;
use App\Models\ProductProductImages;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productImages = ProductImages::latest()->get();
        return view('admin.images.productImages.index', with([
            'productImages' => $productImages,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productIdsWithImages = ProductImages::pluck('products_id')->toArray();
        $products = Products::whereNotIn('id', $productIdsWithImages)->get();
        return view('admin.images.productImages.create', with([
            'products' => $products,
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required',
            'filepath' => 'required',
            'full' => 'required',
        ]);

        $file = $request->file('filepath');

        if (isset($file)) {
            $file = $request->file('filepath');
            $currentDate = now()->toDateString();
            $fileName = $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Create new ImageManager instance with desired driver
            $manager = new ImageManager([Driver::class]); // or ['driver' => 'gd']

            // Read the image
            $image = $manager->make($file->getPathname());

            // Resize and crop the image to a 2:3 aspect ratio (800x1200)
            $croppedImage = $image->resize(320, 370);

            // Save the resized and cropped image to storage
            $croppedImagePath = 'img/products/' . $fileName;
            Storage::disk('public')->put($croppedImagePath, (string) $croppedImage->encode('jpg', 90));
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        try {
            DB::beginTransaction();
            // Logic For Save User Data

            $img = ProductImages::create([
                'products_id' => $request->input('product'),
                'thumbnail' => $fileName,
                'full' => $request->input('full'),
            ]);

            ProductProductImages::create([
                'products_id' => $request->input('product'),
                'product_images_id' => $img->id,
            ]);

            if (!$img) {
                DB::rollBack();

                return back()->with('message', 'Something went wrong while saving user data');
            }
        
            $email = User::whereNotNull('email_verified_at')->pluck('email');
            $product_id = ProductProductImages::where('product_images_id', $img->id)->pluck('products_id');
            $product = Products::with('ProductImage')->find($product_id)->first();
    
            // Mail::to('printshopeld@gmail.com')
            // ->bcc($email)
            // ->send(new newPost($product));

            DB::commit();
            return redirect()->route('product_images.index')->with('message', 'Image Stored Successfully.');
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
        $image = ProductImages::find($id);
        $images = ProductImages::all();
        $product = Products::where('id', $image->products_id)->first();
        return view('admin.images.productImages.edit')->with([
            'image' => $image,
            'images' => $images,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product' => 'required',
            'filepath' => '',
            'full' => '',
        ]);

        $file = $request->file('filepath');

        if (isset($file)) {
            $file = $request->file('filepath');
            $currentDate = now()->toDateString();
            $fileName = $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Create new ImageManager instance with desired driver
            $manager = new ImageManager(Driver::class); // or ['driver' => 'gd']

            // Read the image
            $image = $manager->make($file->getPathname());

            // Resize and crop the image to a 2:3 aspect ratio (800x1200)
            $croppedImage = $image->resize(853, 1280);

            if (!Storage::disk('public')->exists('img/products')) {
                Storage::disk('public')->makeDirectory('img/products');
            }
            
            // Save the resized and cropped image to storage
            $croppedImagePath = 'img/products/' . $fileName;
            Storage::disk('public')->put($croppedImagePath, (string) $croppedImage->encode('jpg', 90));
        } else {
            $fileName = '';
        }

        try {
            DB::beginTransaction();
            // Logic For Save User Data

            $img = ProductImages::find($id);
            if ($img) {
                if ($file) {
                    Storage::delete($img->thumbnail);
                    $img->thumbnail = $fileName;
                }
                $img->full = $request->full;
                $img->products_id = $request->product;


                $img->save();
            } else {
                dd("Image not found");
            }

            ProductProductImages::where('product_images_id', $id)->delete();
            ProductProductImages::create([
                'products_id' => $request->input('product'),
                'product_images_id' => $img->id,
            ]);

            if (!$img) {
                DB::rollBack();

                return back()->with('message', 'Something went wrong while saving user data');
            }

            DB::commit();
            return redirect()->route('product_images.index')->with('message', 'Image updated Successfully.');
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
        $img = ProductImages::find($id);
        // Delete the image file from storage
        if ($img && $img->filepath) {
            Storage::delete($img->filepath);
        }
        $img->delete();
        return redirect()->route('product_images.index')->with('message', 'Image Deleted Successfully.');
    }
}
