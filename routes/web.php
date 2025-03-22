<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogImageController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderItemsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductMaterialController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MpesaPayContorller;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UnderConstructionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 */
Route::get('/under_construction', [UnderConstructionController::class, 'underConstruction'])->name('underConstruction');

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 */

Route::get('/sitemap.xml', function () {
    return response()->file(public_path('sitemap.xml'));
});

Route::get('/admin_', function () {
    return redirect()->route('dashboard.index');
})
    ->middleware('adminauth');

Route::group(['prefix' => '/admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('getLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('postLogin');
    Route::post('/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');
    Route::resource('dashboard', DashboardController::class)->middleware('adminauth');
});

Route::group(['middleware' => 'adminauth'], function () {
    Route::resource('colors', ProductColorController::class);
    Route::resource('sizes', ProductSizeController::class);
    Route::resource('types', ProductTypeController::class);
    Route::resource('materials', ProductMaterialController::class);
    Route::resource('product_categories', ProductCategoryController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('product_images', ProductImageController::class);
    Route::resource('orders', OrdersController::class);
    Route::resource('order_items', OrderItemsController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('users', UserController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('blog_categories', BlogCategoryController::class);
    Route::resource('blog_images', BlogImageController::class);
    Route::resource('contact', ContactsController::class);
    Route::resource('prices', PricesController::class);
    Route::resource('comment', CommentsController::class);

    Route::resource('permissions', PermissionsController::class);
    Route::resource('roles', RolesController::class);

    Route::get('/promo', [PromoCodeController::class, 'index'])->name('promo.index');
    Route::get('/create/promo', [PromoCodeController::class, 'create'])->name('promo.create');
    Route::post('/create-promo', [PromoCodeController::class, 'createPromo'])->name('create.promo');
    Route::get('/promo-edit/{id}', [PromoCodeController::class, 'edit'])->name('promo.edit');
    Route::get('/promo-details/{id}', [PromoCodeController::class, 'show'])->name('promo.show');
    Route::PATCH('/promo-update/{id}', [PromoCodeController::class, 'update'])->name('promo.update');
    Route::DELETE('/promo-destroy/{id}', [PromoCodeController::class, 'destroy'])->name('promo.destroy');

    Route::POST('/generate-review-token', [AdminController::class, 'generateToken'])->name('generateToken');
    Route::get('/review-tokens/index', [ReviewController::class, 'review_tokens_index'])->name('review_tokens.index');
    Route::get('/review/index', [ReviewController::class, 'review_index'])->name('review.index');
    Route::get('/review/show/{id}', [ReviewController::class, 'review_show'])->name('review.show');
    Route::DELETE('/review/destroy/{id}', [ReviewController::class, 'review_destroy'])->name('review.destroy');
});

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Auth::routes(['verify' => true]);
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Route::group(['middleware' => 'TrackVisitorJourney'], function () {
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::redirect('/home', '/');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/catalog', [PagesController::class, 'catalog'])->name('catalog');
    Route::get('/catalog/show/{slug}', [PagesController::class, 'catalog_detail'])->name('catalogDetail');
    Route::get('/catalog/{slug}', [PagesController::class, 'filterByCategory'])->name('catalog.category');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/blog', [PagesController::class, 'blog'])->name('blog');
    Route::get('/blog/single/{slug}', [PagesController::class, 'blog_single'])->name('blogSingle');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/contacts', [PagesController::class, 'contacts'])->name('contacts');
    Route::post('/contact/store', [PagesController::class, 'contactStore'])->name('contactStore');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/comments', [PagesController::class, 'comments'])->name('comments');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/wishlist/{id}', [ProfileController::class, 'wishlist'])->name('wishlist');
    Route::post('/deleteWish/{id}', [ProfileController::class, 'deleteWish'])->name('deleteWish');
    Route::get('/cart', [PagesController::class, 'getCart'])->name('cart');
    Route::get('/cart/add-to-cart/{id}', [PagesController::class, 'add_to_cart'])->name('addToCart');
    Route::post('/cart/add-single/{id}', [PagesController::class, 'add_to_cart_single'])->name('add.single');
    Route::get('/deleteCart/{key}', [PagesController::class, 'deleteCart'])->name('deleteCart');
    Route::post('/updateCart/{id}', [PagesController::class, 'updateCart'])->name('updateCart');
    Route::get('/reduceCart/{key}', [PagesController::class, 'getReduceCart'])->name('reduceCart');
    Route::get('/increaseCart/{key}', [PagesController::class, 'getIncreaseCart'])->name('increaseCart');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/postCheckout/{id}', [CheckoutController::class, 'postCheckout'])->name('postCheckout');
    Route::post('/mpesa/callback', [CheckoutController::class, 'mpesaCallback']);
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::resource('ratings', RatingsController::class);
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/apply-promo', [PromoCodeController::class, 'applyPromo'])->name('promo.apply');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::middleware('guest.review')->group(function () {
        Route::get('/review/create', [ReviewController::class, 'create'])->name('review.create');
        Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
    });
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
});
