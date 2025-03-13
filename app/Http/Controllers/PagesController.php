<?php

namespace App\Http\Controllers;

use App\Mail\newComment;
use App\Mail\newContact;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogImages;
use App\Models\Cart;
use App\Models\Comments;
use App\Models\Contact;
use App\Models\Contacts;
use App\Models\ProductCategories;
use App\Models\ProductColors;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\ProductSizes;
use App\Models\PromoCodes;
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

        $categories = ProductCategories::all();
        $images = ProductImages::with('Products')
            ->latest()
            ->paginate(18);

        return view('pages.catalog', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'images' => $images,
            'categories' => $categories,
        ]));
    }

    /**
     * filter catalog by categories
     *
     * This function does the following:
     * -
     * -
     *
     * @param  Type  parameter  Description
     * @return ReturnType  Description
     */
    public function filterByCategory($slug)
    {
        $pageTitle = 'Catalog';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'Catalog'],
        ];

        $categories = ProductCategories::all();
        $category = ProductCategories::where('slug', $slug)->firstOrFail();
        $images = ProductImages::whereHas('Products', function ($query) use ($category) {
            $query->where('categories_id', $category->id);
        })->latest()->paginate(18);

        return view('pages.catalog', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'images' => $images,
            'categories' => $categories,
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
    public function catalog_detail($slug)
    {
        $pageTitle = 'Catalog Detail';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'catalog detail'],
        ];

        $product = Products::with(['ProductImage', 'ratings', 'Color', 'Size'])->where('slug', $slug)->firstOrFail();

        $images = $product->ProductImage;
        $colors = $product->Color;
        $sizes = $product->Size;
        $averageRating = $product->ratings->avg('rating') ?? 0;

        return view('pages.catalog_detail', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'product' => $product,
            'colors' => $colors,
            'sizes' => $sizes,
            'metaTitle' => $product->meta_title,
            'metaDescription' => $product->meta_description,
            'metaKeywords' => $product->meta_keywords,
            'metaImage' => $product->ProductImage[0]->thumbnail ? asset('storage/img/products/' . $product->ProductImage[0]->thumbnail) : asset('default-meta-image.jpg'),
            'metaUrl' => route('catalogDetail', $product->slug),
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
        $sizes = ProductSizes::all();
        $colors = ProductColors::all();
        $appliedPromo = Session::get('applied_promo');
        $totalPrice = $cart->totalPrice;

        if ($appliedPromo) {
            $totalPrice = 0;
            foreach ($cart->items as $key => $product) {
                $promotion = PromoCodes::where('code', $appliedPromo)->first();
                $promo = $promotion->discount_percentage;
                $originalPrice = $product['item']['products'][0]['price'];
                $discountedPrice = $originalPrice;
                $discountedPrice = $originalPrice - ($originalPrice * $promo) / 100;

                $cart->items[$key]['discounted_price'] = $discountedPrice;
                $totalPrice += $discountedPrice * $cart->items[$key]['qty'];
            }
            Session::put('cart', $cart);
        }

        $availablePromo = PromoCodes::where('expires_at', '>', now())->get();
        $userCanUsePromo = $availablePromo->contains(function ($promo) {
            return $promo->canUserUse(auth()->id());
        });

        return View('pages.cart', [
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'products' => $cart->items,
            'totalPrice' => $totalPrice,
            'shipping' => 300,
            'sizes' => $sizes,
            'colors' => $colors,
            'availablePromo' => $availablePromo,
            'userCanUsePromo' => $userCanUsePromo,
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
        $images = ProductImages::with([
            'products' => function ($query) {
                $query->with('color');
                $query->with('size');
            }
        ])->find($id);

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
    public function blog_single($slug)
    {
        $pageTitle = 'Single Stories';
        $breadcrumbLinks = [
            ['url' => '/', 'label' => 'Home'],
            ['url' => '', 'label' => 'blog single'],
        ];

        $blog = Blog::with(['BlogImage', 'blogCategories', 'comments'])->where('slug', $slug)->firstOrFail();

        return view('pages.blog_single', with([
            'pageTitle' => $pageTitle,
            'breadcrumbLinks' => $breadcrumbLinks,
            'blog' => $blog,
            'metaTitle' => $blog->meta_title,
            'metaDescription' => $blog->meta_description,
            'metaKeywords' => $blog->meta_keywords,
            'metaImage' => $blog->BlogImage[0]->thumbnail ? asset('storage/img/blogs/' . $blog->BlogImage[0]->thumbnail) : asset('default-meta-image.jpg'),
            'metaUrl' => route('blogSingle', $blog->slug),
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

        try {
            DB::beginTransaction();

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

            $contacts = Contacts::where('id', $contacts->id)->first();

            Mail::to('printshopeld@gmail.com')
                ->send(new newContact($contacts));

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

            $comments = Comments::create([
                'content' => $request->message,
                'user_id' => $request->user_id,
                'blog_id' => $request->blog_id,
            ]);

            if (!$comments) {
                DB::rollBack();

                return back()->with('message', 'Something went wrong while saving user data');
            }

            $comments = Comments::with('blog')->where('id', $comments->id)->first();

            DB::commit();
            return redirect()->back()->with('message', 'your comment has been sent Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
