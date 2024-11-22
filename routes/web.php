<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('underConstruction');
});

// // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Auth::routes(['verify' => true]);
// // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Route::get('/', [HomeController::class, 'index'])->name('home');
// // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

















// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/sitemap.xml', function () {
//     return response()->file(public_path('sitemap.xml'));
// });

// Route::get('/admin_', function () {
//     return redirect()->route('dashboard.index');
// })
//     ->middleware('adminauth');

// Route::group(['prefix' => '/admin'], function () {
//     Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('getLogin');
//     Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('postLogin');
//     // Route::post('/register', [AdminAuthController::class, 'postLogin'])->name('postLogin');
//     Route::post('/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');
//     Route::resource('dashboard', DashboardController::class)->middleware('adminauth');
//     Route::get('/schedules', [DashboardController::class, 'schedules'])->name('schedules');
// });

// Route::group(['middleware' => 'adminauth'], function () {
//     Route::resource('colors', ProductColorsController::class);
//     Route::resource('sizes', ProductSizesController::class);
//     Route::resource('types', ProductTypesController::class);
//     Route::resource('materials', ProductMaterialsController::class);
//     Route::resource('product_categories', ProductCategoriesController::class);
//     Route::resource('products', ProductsController::class);
//     Route::resource('product_images', ProductImageController::class);
//     Route::resource('orders', OrdersController::class);
//     Route::resource('order_items', OrderItemsController::class);
//     Route::resource('admins', AdminController::class);
//     Route::resource('users', UserController::class);
//     Route::resource('blogs', BlogsController::class);
//     Route::resource('blog_categories', BlogCategoriesController::class);
//     Route::resource('blog_images', BlogImageController::class);
//     Route::resource('contact', ContactController::class);
//     Route::resource('prices', PricesController::class);
//     Route::resource('comment', CommentsController::class);

//     Route::resource('permissions', PermissionsController::class);
//     Route::resource('roles', RolesController::class);
// });

// // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Auth::routes(['verify' => true]);
// // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Route::group(['middleware' => 'TrackVisitorJourney'], function () {
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::get('/', [HomeController::class, 'index'])->name('home');
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::get('/catalog', [PagesController::class, 'catalog'])->name('catalog');
//     Route::get('/catalog/show/{id}', [PagesController::class, 'catalog_detail'])->name('catalogDetail');
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::get('/blog', [PagesController::class, 'blog'])->name('blog');
//     Route::get('/blog/single/{id}', [PagesController::class, 'blog_single'])->name('blogSingle');
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::get('/contacts', [PagesController::class, 'contacts'])->name('contacts');
//     Route::post('/contact/store', [PagesController::class, 'contactStore'])->name('contactStore');
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::post('/comments', [PagesController::class, 'comments'])->name('comments');
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::post('/wishlist/{id}', [ProfileController::class, 'wishlist'])->name('wishlist');
//     Route::post('/deleteWish/{id}', [ProfileController::class, 'deleteWish'])->name('deleteWish');
//     Route::get('/cart', [PagesController::class, 'getCart'])->name('cart');
//     Route::get('/cart/add/{id}', [PagesController::class, 'add_to_cart'])->name('addToCart');
//     Route::get('/deleteCart/{id}', [PagesController::class, 'deleteCart'])->name('deleteCart');
//     Route::post('/updateCart/{id}', [PagesController::class, 'updateCart'])->name('updateCart');
//     Route::get('/reduceCart/{id}', [PagesController::class, 'getReduceCart'])->name('reduceCart');
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::post('/postCheckout/{id}', [CheckoutController::class, 'postCheckout'])->name('postCheckout');
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::resource('ratings', RatingsController::class);
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     Route::group(['middleware' => ['auth', 'verified']], function () {
//         Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
//         Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profileShow');
//         Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profileEdit');
//         Route::get('/profile/update/{id}', [ProfileController::class, 'update'])->name('profileUpdate');
//     });
//     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// });

