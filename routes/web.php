<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\SEEController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/sse', [SEEController::class, 'sendSSEData']);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';

//Role-----> Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change-password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/change-password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    Route::get('/admin/inactive-vendor', [AdminController::class, 'InActiveVendor'])->name('admin.inactive.vendor');

    Route::get('/admin/active-vendor', [AdminController::class, 'ActiveVendor'])->name('admin.active.vendor');

    Route::get('/admin/inactive-vendor-detail/{id}', [AdminController::class, 'InActiveVendorDetail'])->name('admin.inactive.vendor.detail');

    Route::get('/admin/active-vendor-detail/{id}', [AdminController::class, 'ActiveVendorDetail'])->name('admin.active.vendor.detail');

    Route::post('/admin/inactive-vendor-approve', [AdminController::class, 'InActiveVendorApprove'])->name('admin.inactive.vendor.approve');

    Route::post('/admin/active-vendor-approve', [AdminController::class, 'ActiveVendorApprove'])->name('admin.active.vendor.approve');

    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
});

//Role-----> User
Route::middleware('auth', 'role:user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'Dashboard'])->name('dashboard');
    Route::get('user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('/user/profile', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::post('/user/change-password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::get('/logout', [UserController::class, 'UserDestroy'])->name('user.logout');
});

//Role-----> Vendor
Route::middleware('auth', 'role:vendor')->group(function () {
    // Route::get('/dashboard', [UserController::class, 'Dashboard'])->name('dashboard');
    Route::get('vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    // Route::get('/login', [VendorController::class, 'UserLogin'])->name('login');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
});

//Login
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);

//Sliders
Route::get('/all/slider', [SliderController::class, 'AllSlider'])->name('all.slider');
Route::get('/add/slider', [SliderController::class, 'AddSlider'])->name('add.slider');
Route::post('/store/slider', [SliderController::class, 'StoreSlider'])->name('store.slider');
Route::get('/edit/slider/{id}', [SliderController::class, 'EditSlider'])->name('edit.slider');
Route::post('/update/slider', [SliderController::class, 'UpdateSlider'])->name('update.slider');
Route::get('/delete/slider/{id}', [SliderController::class, 'DeleteSlider'])->name('delete.slider');

//Category
Route::get('/all/category', [CategoryController::class, 'AllCategory'])->name('all.category');
Route::get('/add/category', [CategoryController::class, 'AddCategory'])->name('add.category');
Route::post('/store/category', [CategoryController::class, 'StoreCategory'])->name('store.category');
Route::get('/edit/category/{id}', [CategoryController::class, 'EditCategory'])->name('edit.category');
Route::post('/update/category', [CategoryController::class, 'UpdateCategory'])->name('update.category');
Route::get('/delete/category/{id}', [CategoryController::class, 'DeleteCategory'])->name('delete.category');

//Sub-Category
Route::get('/all/sub-category', [SubCategoryController::class, 'AllSubCategory'])->name('all.sub_category');
Route::get('/add/sub-category', [SubCategoryController::class, 'AddSubCategory'])->name('add.sub_category');
Route::post('/store/sub-category', [SubCategoryController::class, 'StoreSubCategory'])->name('store.sub_category');
Route::get('/subcategory/ajax/{category_id}' , [SubCategoryController::class,'GetSubCategory']);

//Brand
Route::get('/all/brand', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::get('/add/brand', [BrandController::class, 'AddBrand'])->name('add.brand');
Route::post('/store/brand', [BrandController::class, 'StoreBrand'])->name('store.brand');
Route::get('/edit/brand/{id}', [BrandController::class, 'EditBrand'])->name('edit.brand');
Route::post('/update/brand', [BrandController::class, 'UpdateBrand'])->name('update.brand');
Route::get('/delete/brand/{id}', [BrandController::class, 'DeleteBrand'])->name('delete.brand');

//Banner
Route::get('/all/banner', [BannerController::class, 'AllBanner'])->name('all.banner');
Route::get('/add/banner', [BannerController::class, 'AddBanner'])->name('add.banner');
Route::post('/store/banner', [BannerController::class, 'StoreBanner'])->name('store.banner');
Route::get('/edit/brand/{id}', [BannerController::class, 'EditBanner'])->name('edit.banner');
Route::post('/update/banner', [BannerController::class, 'UpdateBanner'])->name('update.banner');
Route::get('/delete/banner/{id}', [BannerController::class, 'DeleteBanner'])->name('delete.banner');

//Product
Route::get('/all/product', [ProductController::class, 'AllProduct'])->name('all.product');
Route::get('/add/product', [ProductController::class, 'AddProduct'])->name('add.product');
Route::post('/store/product', [ProductController::class, 'StoreProduct'])->name('store.product');
