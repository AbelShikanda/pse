<?php

namespace App\Http\Controllers;

use App\Mail\newComment;
use App\Mail\newContact;
use App\Models\Admin;
use App\Models\BlogImages;
use App\Models\Cart;
use App\Models\Comments;
use App\Models\Contact;
use App\Models\Contacts;
use App\Models\ProductColors;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\ProductSizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    /**
     * function to display the information on the catalog page
     *
     * This function does the following:
     * - get data form the databese
     * - pass variable to the catalog page
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function catalog()
    {
        $pageTitle = 'Catalog';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'Catalog'],
        ];

        $images = ProductImages::with('Products')
            ->latest()
            ->get();
        // dd($images);
        // $images = ProductImages::with('Products')
        // ->latest()
        // ->get();
        // dd($images);

        return view('pages.catalog', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'images' => $images,
        ]));
    }

    /**
     * function to display info on catalog_detail page
     *
     * This function does the following:
     * - get data from databese
     * - pass variables to the front
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function catalog_detail($id)
    {
        $pageTitle = 'Catalog Detail';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'catalog detail'],
        ];

        $images = ProductImages::with('products')->find($id);
        $colors = ProductColors::find($id);
        $sizes = ProductSizes::find($id);
        $productId = $images->products[0]->id;
        $product = Products::with('ratings')->findOrFail($productId);
        $averageRating = $product->ratings->avg('rating') ?? 0;

        return view('pages.catalog_detail', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'images' => $images,
            'colors' => $colors,
            'sizes' => $sizes,
            'metaTitle' => $images->products[0]->meta_title,
            'metaDescription' => $images->products[0]->meta_description,
            'metaKeywords' => $images->products[0]->meta_keywords,
            'metaImage' => $images->thumbnail ? asset('storage/img/products/' . $images->thumbnail) : asset('default-meta-image.jpg'),
            'metaUrl' => route('catalogDetail', $images->id),
            'averageRating' => $averageRating,
        ]));
    }

    public function getCart()
    {
        $pageTitle = 'Cart';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'catalog detail'],
            ['url' => '', 'label' => 'cart'],
        ];

        if (!Session::has('cart')) {
            return redirect()->route('catalog')->with('message', 'There is currently nothing in your cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // dd($cart, $cart->items, $cart->items['6']['item']['products']);
        // dd($cart->items['item']['products']['0']['name']);
        // foreach ($cart->items as $item) {
        //     foreach ($item['item']['products'] as $item) {
        //         dd($item['size']);
        //     }
        //     // dd($item['item']['id']);
        // }
        // $products_id = $cart->items['item']['products']['0']['id'];
        return View('pages.cart', [
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'products' => $cart->items,
            'totalPrice' => $cart->totalPrice,
            'shipping' => 300,
        ]);
    }

    /**
     * FUnction to add to cart
     *
     * This function does the following:
     * - Step 1
     * - Step 2
     * - Step 3
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function add_to_cart(Request $request, $id)
    {
        // $images = ProductImages::with('products')->find($id);
        $images = ProductImages::with([
            'products' => function ($query) {
                $query->with('color'); // example for product color
                $query->with('size'); // example for product color
            }
        ])->find($id);
        // dd($images);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($images, $images->id);

        $request->session()->put('cart', $cart);

        $pageTitle = 'Cart';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'catalog detail'],
            ['url' => '', 'label' => 'cart'],
        ];

        return redirect()->route('cart')->with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
        ]);
    }

    public function updateCart(Request $request, $id)
    {
        $size = $request->size;
        $color = $request->color;
        $images = ProductImages::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->update($images, $images->id, $size, $color);

        $pageTitle = 'Cart';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'catalog detail'],
            ['url' => '', 'label' => 'cart'],
        ];
        Session::put('cart', $cart);
        return redirect()->route('cart')->with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
        ]);
    }

    public function getReduceCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduce($id);

        $pageTitle = 'Cart';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'catalog detail'],
            ['url' => '', 'label' => 'cart'],
        ];
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('cart')->with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
        ]);
    }

    public function deleteCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
            return redirect()->route('cart');
        } else {
            Session::forget('cart');
            return redirect()->route('catalog');
        }
    }

    /**
     * function to display blog detail
     *
     * This function does the following:
     * - retireves data from the database
     * - displays the data on the blog
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function blog()
    {
        $pageTitle = 'stories';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'blog'],
        ];
        $blogs = BlogImages::with('blogs')->orderBy('id', 'DESC')->get();
        // dd($blogs);

        return view('pages.blog', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'blogs' => $blogs,
        ]));
    }

    /**
     * function to display info on blog single page
     *
     * This function does the following:
     * - retrieve data from the database
     * - pass data as variables to tne page
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function blog_single($id)
    {
        $pageTitle = 'Single Stories';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'blog single'],
        ];

        $blog = BlogImages::with([
            'blogs',
            'blogs.blogCategories',
            'blogs.comments',
        ])
            ->where('id', $id)
            ->orderBy('id', 'DESC')
            ->first();
            
        $comments = Comments::with('blog', 'user')->where('blog_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('pages.blog_single', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'blog' => $blog,
            'comments' => $comments,
            'metaTitle' => $blog->blogs[0]->meta_title,
            'metaDescription' => $blog->blogs[0]->meta_description,
            'metaKeywords' => $blog->blogs[0]->meta_keywords,
            'metaImage' => $blog->thumbnail ? asset('storage/img/blogs/' . $blog->thumbnail) : asset('default-meta-image.jpg'),
            'metaUrl' => route('blogSingle', $blog->id),
        ]));
    }

    /**
     * function for the contact page
     *
     * This function does the following:
     * - send email to the site
     * - store the message in the database
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function contacts(Request $request)
    {
        $pageTitle = 'Contact';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'Contact'],
        ];

        return view('pages.contact', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
        ]));
    }


    /**
     * function for the contact page
     *
     * This function does the following:
     * - send email to the site
     * - store the message in the database
     *
     * @param  Parameter type  Parameter name Description of the parameter (optional)
     * @return Return type Description of the return value (optional)
     */
    public function contactStore(Request $request)
    {
        $contacts = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        // dd($contacts);

        try {
            DB::beginTransaction();
            // Logic For Save User Data

            $contacts = Contacts::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            if (!$contacts) {
                DB::rollBack();
                return back()->with([
                    'message' => 'Something went wrong while saving user data.',
                ]);
            }

            $email = Admin::where('is_admin', 1)->pluck('email');
            $contacts = Contacts::where('id', $contacts->id)->first();

            // Mail::to('printshopeld@gmail.com')
            //     ->bcc($email)
            //     ->send(new newContact($contacts));

            DB::commit();
            return redirect()->back()->with([
                'message' => 'Your message has been sent successfully.',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function comments(Request $request)
    {
        $comments = $request->validate([
            'message' => 'required',
            'user_id' => 'required',
            'blog_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            // Logic For Save User Data

            $comments = Comments::create([
                'content' => $request->message,
                'user_id' => $request->user_id,
                'blog_id' => $request->blog_id,
            ]);

            if (!$comments) {
                DB::rollBack();

                return back()->with('message', 'Something went wrong while saving user data');
            }

            $email = Admin::where('is_admin', 1)->pluck('email');

            $comments = Comments::with('blog')->where('id', $comments->id)->first();

            // dd($comments->blog->title);

            // Mail::to('printshopeld@gmail.com')
            //     ->bcc($email)
            //     ->send(new newComment($comments));

            DB::commit();
            return redirect()->back()->with('message', 'your comment has been sent Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
