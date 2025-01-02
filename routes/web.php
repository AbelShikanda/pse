<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
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
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\UnderConstructionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/under_construction', [UnderConstructionController::class, 'underConstruction'])->name('underConstruction');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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
    Route::get('/catalog/show/{id}', [PagesController::class, 'catalog_detail'])->name('catalogDetail');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/blog', [PagesController::class, 'blog'])->name('blog');
    Route::get('/blog/single/{id}', [PagesController::class, 'blog_single'])->name('blogSingle');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/contacts', [PagesController::class, 'contacts'])->name('contacts');
    Route::post('/contact/store', [PagesController::class, 'contactStore'])->name('contactStore');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/comments', [PagesController::class, 'comments'])->name('comments');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/wishlist/{id}', [ProfileController::class, 'wishlist'])->name('wishlist');
    Route::post('/deleteWish/{id}', [ProfileController::class, 'deleteWish'])->name('deleteWish');
    Route::get('/cart', [PagesController::class, 'getCart'])->name('cart');
    Route::get('/cart/add/{id}', [PagesController::class, 'add_to_cart'])->name('addToCart');
    Route::get('/deleteCart/{id}', [PagesController::class, 'deleteCart'])->name('deleteCart');
    Route::post('/updateCart/{id}', [PagesController::class, 'updateCart'])->name('updateCart');
    Route::get('/reduceCart/{id}', [PagesController::class, 'getReduceCart'])->name('reduceCart');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/postCheckout/{id}', [CheckoutController::class, 'postCheckout'])->name('postCheckout');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::resource('ratings', RatingsController::class);
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profileShow');
        Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profileEdit');
        Route::get('/profile/update/{id}', [ProfileController::class, 'update'])->name('profileUpdate');
    });
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
});

