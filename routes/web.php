<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\user\ShopController as UserProduct;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\user\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware('user')->group(function () {
    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::post('/addcart', [CartController::class, 'addcart'])->name('addcart');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

    Route::get('/products/{id}-{slug}', [UserProduct::class, 'productDetail'])->name('products');


    //Size
    // Route::get('/products/{id}-{slug}',[SizeController::class,'chooseSize'])->name('chooseSize');
    

    
    Route::post('/sizeproducts', [UserProduct::class, 'getSize'])->name('sizeProducts');


    Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
    Route::get('/shop', [UserProduct::class, 'products'])->name('shop');
    Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');

    Route::get('/profile', [FrontendController::class, 'profile'])->name('profile');


    Route::get('/mail', [FrontendController::class, 'testmail']);
    Route::get('/mailto', [FrontendController::class, 'vmail']);


});


Route::name('user.')->middleware(['auth', 'user'])->group(function () {

    Route::get('/cart', [CartController::class, 'showCart'])->name('showcart');

    Route::get('/delItem/{id}', [OrderController::class, 'delItem'])->name('delItem');
    Route::post('/upQty', [OrderController::class, 'updateQty'])->name('updateQty');
    Route::post('/cart', [OrderController::class, 'appCoupon'])->name('coupon');
    Route::get('/checkout', [OrderController::class, 'checkOut'])->name('checkout');

});

//Profile
Route::name('user.')->prefix('profile')->middleware(['auth', 'user'])->group(function () {
    Route::get('/{id}', [ProfileController::class, 'show'])->name('profile');
    Route::post('/{id}', [ProfileController::class, 'ajaxRequest'])->name('ajaxRequest');
    Route::post('/user/{id}', [ProfileController::class, 'update'])->name('update');
    Route::get('/pass/{id}', [ProfileController::class, 'changePass'])->name('change');
    Route::post('/pass/{id}', [ProfileController::class, 'updatePass'])->name('update.pass');
    Route::get('/orders/{id}', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/favorites/{id}', [ProfileController::class, 'favorites'])->name('favorites');
    Route::get('/comments/{id}', [ProfileController::class, 'comments'])->name('comments');
});


Auth::routes();

Route::name('admin.')->prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/store', [UserController::class, 'store']);
    Route::get('/users/detail/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/search', [AdminController::class, 'search'])->name('addCategory');



    //comment
    Route::get('/comment', [CommentController::class, 'index'])->name('comment');


    Route::get('/', [DashboardController::class, 'show'])->name('admin');
    Route::get('/blog', [AdminController::class, 'blog'])->name('blog');
    Route::get('/invoice', [AdminController::class, 'invoice'])->name('invoice');
    Route::post('/addProduct', [ProductController::class, 'store'])->name('add');

   #Product
   Route::post('/addProduct', [ProductController::class, 'store'])->name('addProduct');
   Route::get('/addProduct', [ProductController::class, 'create'])->name('indexProduct');
   Route::get('/showProduct', [ProductController::class, 'index'])->name('showProduct');
   Route::get('/detailProduct/{id}', [ProductController::class, 'show'])->name('detailProduct');
   Route::get('/editProduct/{id}', [ProductController::class, 'edit'])->name('editProduct');
   Route::get('/showProduct/{id}', [ProductController::class, 'destroy'])->name('deleteProduct');
   Route::post('/updateProduct/{id}', [ProductController::class, 'update'])->name('updateProduct');
   Route::post('/showProduct',[ProductController::class,'searchProduct'])->name('searchProduct');
   Route::get('/activeProduct/{id}',[ProductController::class,'activeProduct'])->name('activeProduct');
   Route::get('/unactiveProduct/{id}',[ProductController::class,'unactiveProduct'])->name('unactiveProduct');


   #Category
   Route::get('/addCategory', [CategoryController::class, 'index'])->name('addCategory');
   Route::get('/showCategory', [CategoryController::class, 'show'])->name('showCategory');
   Route::get('/showCategory/View/{id}', [CategoryController::class, 'detail'])->name('detailCategory');
   Route::get('/editCategory/{id}', [CategoryController::class, 'edit'])->name('editCategory');
   Route::post('/updateCategory/{id}', [CategoryController::class, 'update'])->name('updateCategory');
   Route::post('/addCategory', [CategoryController::class, 'store'])->name('addCategory');
   Route::get('/showCategory/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');


   //Dashboard


   //Invoice
   Route::get('/Invoice', [OrderController::class, 'index'])->name('indexInvoice');

});