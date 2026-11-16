<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogImageController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\DashboardController;
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
    Route::resource('dashboard', DashboardController::class)->only(['index'])->middleware('adminauth');
    Route::get('/dashboard/schedules', [DashboardController::class, 'schedules'])->name('schedules')->middleware('adminauth');
});

Route::group(['middleware' => 'adminauth'], function () {
    Route::resource('colors', \App\Http\Controllers\Admin\ProductColorController::class)->except(['show'])->middleware('admin.permission:viewCategories')->only(['index', 'show']);
    Route::resource('colors', \App\Http\Controllers\Admin\ProductColorController::class)->except(['show'])->middleware('admin.permission:createCategories')->only(['create', 'store']);
    Route::resource('colors', \App\Http\Controllers\Admin\ProductColorController::class)->except(['show'])->middleware('admin.permission:editCategories')->only(['edit', 'update']);
    Route::resource('colors', \App\Http\Controllers\Admin\ProductColorController::class)->except(['show'])->middleware('admin.permission:deleteCategories')->only(['destroy']);
    Route::resource('sizes', \App\Http\Controllers\Admin\ProductSizeController::class)->except(['show'])->middleware('admin.permission:viewCategories')->only(['index', 'show']);
    Route::resource('sizes', \App\Http\Controllers\Admin\ProductSizeController::class)->except(['show'])->middleware('admin.permission:createCategories')->only(['create', 'store']);
    Route::resource('sizes', \App\Http\Controllers\Admin\ProductSizeController::class)->except(['show'])->middleware('admin.permission:editCategories')->only(['edit', 'update']);
    Route::resource('sizes', \App\Http\Controllers\Admin\ProductSizeController::class)->except(['show'])->middleware('admin.permission:deleteCategories')->only(['destroy']);
    Route::resource('types', \App\Http\Controllers\Admin\ProductTypeController::class)->except(['show'])->middleware('admin.permission:viewCategories')->only(['index', 'show']);
    Route::resource('types', \App\Http\Controllers\Admin\ProductTypeController::class)->except(['show'])->middleware('admin.permission:createCategories')->only(['create', 'store']);
    Route::resource('types', \App\Http\Controllers\Admin\ProductTypeController::class)->except(['show'])->middleware('admin.permission:editCategories')->only(['edit', 'update']);
    Route::resource('types', \App\Http\Controllers\Admin\ProductTypeController::class)->except(['show'])->middleware('admin.permission:deleteCategories')->only(['destroy']);
    Route::resource('materials', \App\Http\Controllers\Admin\ProductMaterialController::class)->except(['show'])->middleware('admin.permission:viewCategories')->only(['index', 'show']);
    Route::resource('materials', \App\Http\Controllers\Admin\ProductMaterialController::class)->except(['show'])->middleware('admin.permission:createCategories')->only(['create', 'store']);
    Route::resource('materials', \App\Http\Controllers\Admin\ProductMaterialController::class)->except(['show'])->middleware('admin.permission:editCategories')->only(['edit', 'update']);
    Route::resource('materials', \App\Http\Controllers\Admin\ProductMaterialController::class)->except(['show'])->middleware('admin.permission:deleteCategories')->only(['destroy']);
    Route::resource('product_categories', \App\Http\Controllers\Admin\ProductCategoryController::class)->except(['show'])->middleware('admin.permission:viewCategories')->only(['index', 'show']);
    Route::resource('product_categories', \App\Http\Controllers\Admin\ProductCategoryController::class)->except(['show'])->middleware('admin.permission:createCategories')->only(['create', 'store']);
    Route::resource('product_categories', \App\Http\Controllers\Admin\ProductCategoryController::class)->except(['show'])->middleware('admin.permission:editCategories')->only(['edit', 'update']);
    Route::resource('product_categories', \App\Http\Controllers\Admin\ProductCategoryController::class)->except(['show'])->middleware('admin.permission:deleteCategories')->only(['destroy']);
    Route::resource('blog_categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->except(['show'])->middleware('admin.permission:viewCategories')->only(['index', 'show']);
    Route::resource('blog_categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->except(['show'])->middleware('admin.permission:createCategories')->only(['create', 'store']);
    Route::resource('blog_categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->except(['show'])->middleware('admin.permission:editCategories')->only(['edit', 'update']);
    Route::resource('blog_categories', \App\Http\Controllers\Admin\BlogCategoryController::class)->except(['show'])->middleware('admin.permission:deleteCategories')->only(['destroy']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)->middleware('admin.permission:viewProducts')->only(['index', 'show']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)->middleware('admin.permission:createProducts')->only(['create', 'store']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)->middleware('admin.permission:editProducts')->only(['edit', 'update']);
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)->middleware('admin.permission:deleteProducts')->only(['destroy']);
    Route::resource('product_images', \App\Http\Controllers\Admin\ProductImageController::class)->except(['show'])->middleware('admin.permission:viewImages')->only(['index', 'show']);
    Route::resource('product_images', \App\Http\Controllers\Admin\ProductImageController::class)->except(['show'])->middleware('admin.permission:createImages')->only(['create', 'store']);
    Route::resource('product_images', \App\Http\Controllers\Admin\ProductImageController::class)->except(['show'])->middleware('admin.permission:editImages')->only(['edit', 'update']);
    Route::resource('product_images', \App\Http\Controllers\Admin\ProductImageController::class)->except(['show'])->middleware('admin.permission:deleteImages')->only(['destroy']);
    Route::resource('orders', \App\Http\Controllers\Admin\OrdersController::class)->only(['index', 'show'])->middleware('admin.permission:viewOrders');
    Route::resource('orders', \App\Http\Controllers\Admin\OrdersController::class)->only(['update'])->middleware('admin.permission:editOrders');
    Route::resource('orders', \App\Http\Controllers\Admin\OrdersController::class)->only(['destroy'])->middleware('admin.permission:deleteOrders');
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->middleware('admin.permission:viewAdmins')->only(['index', 'show']);
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->middleware('admin.permission:createAdmins')->only(['create', 'store']);
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->middleware('admin.permission:editAdmins')->only(['edit', 'update']);
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->middleware('admin.permission:deleteAdmins')->only(['destroy']);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show'])->middleware('admin.permission:viewUsers');
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->middleware('admin.permission:viewBlogs')->only(['index', 'show']);
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->middleware('admin.permission:createBlogs')->only(['create', 'store']);
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->middleware('admin.permission:editBlogs')->only(['edit', 'update']);
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)->middleware('admin.permission:deleteBlogs')->only(['destroy']);
    Route::resource('blog_images', \App\Http\Controllers\Admin\BlogImageController::class)->except(['show'])->middleware('admin.permission:viewImages')->only(['index', 'show']);
    Route::resource('blog_images', \App\Http\Controllers\Admin\BlogImageController::class)->except(['show'])->middleware('admin.permission:createImages')->only(['create', 'store']);
    Route::resource('blog_images', \App\Http\Controllers\Admin\BlogImageController::class)->except(['show'])->middleware('admin.permission:editImages')->only(['edit', 'update']);
    Route::resource('blog_images', \App\Http\Controllers\Admin\BlogImageController::class)->except(['show'])->middleware('admin.permission:deleteImages')->only(['destroy']);
    Route::resource('contact', \App\Http\Controllers\Admin\ContactsController::class)->only(['index', 'show'])->middleware('admin.permission:viewContacts');
    Route::resource('prices', \App\Http\Controllers\PricesController::class)->except(['show'])->middleware('admin.permission:viewPrices')->only(['index', 'show']);
    Route::resource('prices', \App\Http\Controllers\PricesController::class)->except(['show'])->middleware('admin.permission:createPrices')->only(['create', 'store']);
    Route::resource('prices', \App\Http\Controllers\PricesController::class)->except(['show'])->middleware('admin.permission:editPrices')->only(['edit', 'update']);
    Route::resource('prices', \App\Http\Controllers\PricesController::class)->except(['show'])->middleware('admin.permission:deletePrices')->only(['destroy']);
    Route::resource('comment', \App\Http\Controllers\Admin\CommentsController::class)->only(['index'])->middleware('admin.permission:viewComments');
    Route::resource('comment', \App\Http\Controllers\Admin\CommentsController::class)->only(['destroy'])->middleware('admin.permission:deleteComments');
    Route::get('/ratings', [\App\Http\Controllers\RatingsController::class, 'index'])->name('ratings.index')->middleware('admin.permission:viewRatings');
    Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class)->middleware('admin.permission:viewRoles')->only(['index', 'show']);
    Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class)->middleware('admin.permission:createRoles')->only(['create', 'store']);
    Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class)->middleware('admin.permission:editRoles')->only(['edit', 'update']);
    Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class)->middleware('admin.permission:deleteRoles')->only(['destroy']);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionsController::class)->only(['index'])->middleware('admin.permission:viewPermissions');

    Route::get('/promo', [\App\Http\Controllers\Admin\PromoCodeController::class, 'index'])->name('promo.index')->middleware('admin.permission:viewSettings');
    Route::get('/create/promo', [\App\Http\Controllers\Admin\PromoCodeController::class, 'create'])->name('promo.create')->middleware('admin.permission:createSettings');
    Route::post('/create-promo', [\App\Http\Controllers\Admin\PromoCodeController::class, 'createPromo'])->name('create.promo')->middleware('admin.permission:createSettings');
    Route::get('/promo-edit/{id}', [\App\Http\Controllers\Admin\PromoCodeController::class, 'edit'])->name('promo.edit')->middleware('admin.permission:editSettings');
    Route::get('/promo-details/{id}', [\App\Http\Controllers\Admin\PromoCodeController::class, 'show'])->name('promo.show')->middleware('admin.permission:editSettings');
    Route::PATCH('/promo-update/{id}', [\App\Http\Controllers\Admin\PromoCodeController::class, 'update'])->name('promo.update')->middleware('admin.permission:editSettings');
    Route::DELETE('/promo-destroy/{id}', [\App\Http\Controllers\Admin\PromoCodeController::class, 'destroy'])->name('promo.destroy')->middleware('admin.permission:deleteSettings');

    Route::POST('/generate-review-token', [\App\Http\Controllers\Admin\AdminController::class, 'generateToken'])->name('generateToken')->middleware('admin.permission:createRatings');
    Route::get('/review-tokens/index', [\App\Http\Controllers\ReviewController::class, 'review_tokens_index'])->name('review_tokens.index')->middleware('admin.permission:viewRatings');
    Route::get('/review/index', [\App\Http\Controllers\ReviewController::class, 'review_index'])->name('review.index')->middleware('admin.permission:viewRatings');
    Route::get('/review/show/{id}', [\App\Http\Controllers\ReviewController::class, 'review_show'])->name('review.show')->middleware('admin.permission:viewRatings');
    Route::DELETE('/review/destroy/{id}', [\App\Http\Controllers\ReviewController::class, 'review_destroy'])->name('review.destroy')->middleware('admin.permission:deleteRatings');
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
    Route::post('/api/mpesa/callback', [CheckoutController::class, 'mpesaCallback'])->withoutMiddleware(['auth']);
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::post('/ratings', [RatingsController::class, 'store'])->middleware('auth')->name('ratings.store');
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
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
