<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PromotionController;
use App\Http\Controllers\OrderController as UserOrder;
use App\Http\Controllers\CartController;
use App\Http\Controllers\user\ShopController as UserProduct;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Social\SocialController;
use App\Http\Controllers\user\AddressController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware(['user'])->group(function () {
    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::post('/addcart', [CartController::class, 'addcart'])->name('addcart');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::get('/products/{id}-{slug}', [UserProduct::class, 'productDetail'])->name('products');
    Route::post('/sizeproducts', [CartController::class, 'getSize'])->name('sizeProducts');

    Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
    Route::get('/shop', [UserProduct::class, 'products'])->name('shop');
    Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
    Route::get('/shop', [UserProduct::class, 'products'])->name('shop');

    Route::post('/shop/filter', [UserProduct::class, 'filterPrice'])->name('filterPrice');
    Route::post('/shop/filterCate', [UserProduct::class, 'filterCate'])->name('filterCate');
    Route::get('/confirmOrder/{id}', [FrontendController::class, 'confirmOrder'])->name('confirmOrder');

    Route::get('/profile', [FrontendController::class, 'profile'])->name('profile');

    Route::post('/whitelist', [UserProduct::class, 'addwList'])->name('addwList');

    Route::get('/mail', [FrontendController::class, 'testmail'])->name('testmail');


    // search
    Route::get('/search-header', [FrontendController::class, 'search'])->name('search_header');
});


Route::name('user.')->middleware(['auth', 'user'])->group(function () {

    Route::get('/cart', [CartController::class, 'showCart'])->name('showcart');
    Route::get('/delItem/{id}', [UserOrder::class, 'delItem'])->name('delItem');
    Route::post('/upQty', [UserOrder::class, 'updateQty'])->name('updateQty');
    Route::post('/cart', [UserOrder::class, 'addCoupon'])->name('coupon');

    Route::post('/changadd/{id}', [AddressController::class, 'changeadd'])->name('changeAdd');
    Route::get('/checkout', [UserOrder::class, 'showCheckOut'])->name('checkout');
    Route::post('/firmcheckout', [UserOrder::class, 'checkOut'])->name('firmCheckout');

    Route::get('/thanks', [UserOrder::class, 'thanks'])->name('thanks');

    Route::post('/review', [ReviewController::class, 'review'])->name('review');


    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'show'])->name('profile');
        Route::post('/{id}', [ProfileController::class, 'ajaxRequest'])->name('ajaxRequest');
        Route::post('/user/{id}', [ProfileController::class, 'update'])->name('update');
        Route::get('/del/{id}', [AddressController::class, 'deladdress'])->name('deladd');
        Route::post('/saveinfo', [AddressController::class, 'createadd'])->name('createadd');

        Route::get('/pass/{id}', [ProfileController::class, 'changePass'])->name('change');
        Route::post('/pass/{id}', [ProfileController::class, 'updatePass'])->name('update.pass');
        Route::get('/favorites/{id}', [ProfileController::class, 'favorites'])->name('favorites');
        Route::get('/comments/{id}', [ProfileController::class, 'comments'])->name('comments');


        Route::get('/orders/{id}', [ProfileController::class, 'orders'])->name('orders');
        Route::get('/order/{id}', [ProfileController::class, 'orderDetail'])->name('order');
    });
});



Auth::routes();
Route::get('/auth/redirect/{provider}', [SocialController::class, 'redirect'])->name('social');
Route::get('/callback/{provider}', [SocialController::class, 'callback']);


Route::name('admin.')->prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/store', [UserController::class, 'store']);
    Route::get('/users/detail/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/search', [AdminController::class, 'search'])->name('addCategory');

    Route::get('/PDF/{id}', [FrontendController::class, 'generatePDF'])->name('generatePDF');
    //Promotions
    Route::get('/promotions', [PromotionController::class, 'index'])->name('promotion');
    Route::get('/addPro', [PromotionController::class, 'add'])->name('addpro');
    Route::post('/addPro', [PromotionController::class, 'store'])->name('storepro');
    Route::get('/promotions/{id}', [PromotionController::class, 'delete'])->name('delpro');

    //comment
    Route::get('/comment', [CommentController::class, 'index'])->name('comment');
    Route::post('/comment', [CommentController::class, 'showHide'])->name('showComment');
    Route::get('/feedback/{id}', [CommentController::class, 'feedback'])->name('feedback');
    Route::post('/feedback', [CommentController::class, 'postFeedBack'])->name('postFeedback');

    //ban user
    Route::post('user/{id}/ban', [UserController::class, 'ban'])->name('ban');
    Route::get('user/{id}/unban', [UserController::class, 'Unban'])->name('Unban');
    

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
    Route::post('/showProduct', [ProductController::class, 'searchProduct'])->name('searchProduct');
    Route::get('/activeProduct/{id}', [ProductController::class, 'activeProduct'])->name('activeProduct');
    Route::get('/unactiveProduct/{id}', [ProductController::class, 'unactiveProduct'])->name('unactiveProduct');



    #Order
    Route::get('/order', [OrderController::class, 'order'])->name('order');
    Route::get('/orderdetail/{id}', [OrderController::class, 'orderdetail'])->name('orderdetail');
    Route::post('/search', [OrderController::class, 'searchOrder'])->name('search');

    Route::get('/orderDay', [DashboardController::class, 'orderDay'])->name('orderDday');
    Route::get('/orderMonth', [DashboardController::class, 'orderMonth'])->name('orderMonth');

    #Category
    Route::get('/addCategory', [CategoryController::class, 'index'])->name('addCategory');
    Route::get('/showCategory', [CategoryController::class, 'show'])->name('showCategory');
    Route::get('/showCategory/View/{id}', [CategoryController::class, 'detail'])->name('detailCategory');
    Route::get('/editCategory/{id}', [CategoryController::class, 'edit'])->name('editCategory');
    Route::post('/updateCategory/{id}', [CategoryController::class, 'update'])->name('updateCategory');
    Route::post('/addCategory', [CategoryController::class, 'store'])->name('addCategory');
    Route::get('/showCategory/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');


    //Dashboard


});