<?php

use Illuminate\Support\Facades\Route;
USE Illuminate\Support\Facades\Auth;
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
    return view('pages.index');
});
Auth::routes(['verify' => true]);
//Admin Routes
Route::middleware(['Category'])->group(function(){
//Admin Section
Route::get('admin/categories', 'Admin\Category\CategoryController@category')->name('categories');
//categories
Route::post('admin/store/category', 'Admin\Category\CategoryController@storecategory')->name('store.category');
//delete Category
Route::get('delete/category/{id}', 'Admin\Category\CategoryController@Deletecategory');
//edit & update category
Route::get('edit/category/{id}', 'Admin\Category\CategoryController@Editcategory');
Route::post('update/category/{id}', 'Admin\Category\CategoryController@Updatecategory');
});

Route::middleware(['Coupon'])->group(function(){
// Coupons All
Route::get('admin/sub/coupon', 'Admin\Category\CouponController@Coupon')->name('admin.coupon');
Route::post('admin/store/coupon', 'Admin\Category\CouponController@StoreCoupon')->name('store.coupon');
Route::get('delete/coupon/{id}', 'Admin\Category\CouponController@DeleteCoupon');
Route::get('edit/coupon/{id}', 'Admin\Category\CouponController@EditCoupon');
Route::post('update/coupon/{id}', 'Admin\Category\CouponController@UpdateCoupon');

});
Route::middleware(['Product'])->group(function(){
// Products All Routes
Route::get('admin/product/all', 'Admin\ProductController@index')->name('all.product');
Route::get('admin/product/add', 'Admin\ProductController@create')->name('add.product');
Route::post('admin/store/product', 'Admin\ProductController@store')->name('store.product');
//active & inactive
Route::get('inactive/product/{id}', 'Admin\ProductController@inactive');
Route::get('active/product/{id}', 'Admin\ProductController@active');
Route::get('delete/product/{id}', 'Admin\ProductController@DeleteProduct');
Route::get('view/product/{id}', 'Admin\ProductController@ViewProduct');
Route::get('edit/product/{id}', 'Admin\ProductController@EditProduct');
Route::post('update/product/withoutphoto/{id}', 'Admin\ProductController@UpdateProductWithoutPhoto');
Route::post('update/product/photo/{id}', 'Admin\ProductController@UpdateProductPhoto');
// For Show Sub category with ajax
Route::get('get/subcategory/{category_id}', 'Admin\ProductController@GetSubcat');
});
Route::middleware(['UserRole'])->group(function(){
// Admin Role Routes
Route::get('admin/all/user', 'Admin\UserRoleController@UserRole')->name('admin.all.user');
Route::get('admin/create/admin', 'Admin\UserRoleController@UserCreate')->name('create.admin');
Route::post('admin/store/admin', 'Admin\UserRoleController@UserStore')->name('store.admin');
Route::get('delete/admin/{id}', 'Admin\UserRoleController@UserDelete');
Route::get('edit/admin/{id}', 'Admin\UserRoleController@UserEdit');
Route::post('admin/update/admin', 'Admin\UserRoleController@UserUpdate')->name('update.admin');
});

Route::middleware(['Brands'])->group(function(){
    //Brands
    Route::get('admin/brands', 'Admin\Category\BrandController@brand')->name('brands');
    Route::post('admin/store/brand', 'Admin\Category\BrandController@storebrand')->name('store.brand');
    Route::get('delete/brand/{id}', 'Admin\Category\BrandController@DeleteBrand');
    Route::post('update/brand/{id}', 'Admin\Category\BrandController@UpdateBrand');
    Route::get('edit/brand/{id}', 'Admin\Category\BrandController@EditBrand');
});



Route::middleware(['subcategory'])->group(function(){
    //sub category
    Route::get('admin/sub/category', 'Admin\Category\SubCategoryController@subcategories')->name('sub.categories');
    Route::post('admin/store/subcat', 'Admin\Category\SubCategoryController@storesubcat')->name('store.subcategory');
    Route::get('delete/subcategory/{id}', 'Admin\Category\SubCategoryController@DeleteSubcat');
    Route::get('edit/subcategory/{id}', 'Admin\Category\SubCategoryController@EditSubcat');
    Route::post('update/subcategory/{id}', 'Admin\Category\SubCategoryController@UpdateSubcat');
    Route::get('delete/sub/{id}', 'Admin\Category\CouponController@DeleteSub');
});


Route::middleware(['Blog'])->group(function(){
    //all Blog routes
    Route::get('blog/category/list', 'Admin\PostController@BlogCatlist')->name('add.blog.categorylist');
    Route::post('admin/store/blog', 'Admin\PostController@BlogCatStore')->name('store.blog.category');
    Route::get('delete/blogcategory/{id}', 'Admin\PostController@DeleteBlogCat');
    Route::get('edit/blogcategory/{id}', 'Admin\PostController@EditBlogCat');
    Route::post('update/blog/category/{id}', 'Admin\PostController@UpdateBlogCat');
    // Newslater
    Route::get('admin/newslater', 'Admin\Category\CouponController@Newslater')->name('admin.newslater');
    // All Posts route
    Route::get('admin/add/post', 'Admin\PostController@Create')->name('add.blogpost');
    Route::get('admin/all/post', 'Admin\PostController@index')->name('all.blogpost');
    Route::post('admin/store/post', 'Admin\PostController@store')->name('store.post');
    Route::get('delete/post/{id}', 'Admin\PostController@DeletePost');
    Route::get('edit/post/{id}', 'Admin\PostController@EditPost');
    Route::post('update/post/{id}', 'Admin\PostController@UpdatePost');
});



Route::middleware(['Order'])->group(function(){
    //Admin Order Route
    //show new order page --- stauts ==0
    Route::get('admin/pading/order', 'Admin\OrderController@NewOrder')->name('admin.neworder');
    //show order details (id) --- stutes changable according user
    Route::get('admin/view/order/{id}', 'Admin\OrderController@ViewOrder');
    //show orders that has status ==1
    Route::get('admin/accep/payment', 'Admin\OrderController@AccepPayment')->name('admin.accept.payment');
    //updade status (0)---->(1)
    Route::get('admin/payment/accept/{id}', 'Admin\OrderController@PaymentAccept');
    //show orders that we canceld
    Route::get('admin/cancel/order', 'Admin\OrderController@ConcelOrder')->name('admin.cancel.order');
    //update stutes from 0 to 2
    Route::get('admin/payment/cancel/{id}', 'Admin\OrderController@PaymentCancel');
    //show orders that has status 3
    Route::get('admin/process/payment', 'Admin\OrderController@ProcessPayment')->name('admin.process.payment');
    //update status from 1 to 3
    Route::get('admin/delevery/process/{id}', 'Admin\OrderController@DeleveryProcess');
    //show orders have status ==4
    Route::get('admin/success/payment', 'Admin\OrderController@SuccessPayment')->name('admin.success.payment');
    //update status from 3 to 4
    Route::get('admin/delevery/done/{id}', 'Admin\OrderController@DeleveryDone');
    //seo setting route
    Route::post('admin/seo/update', 'Admin\OrderController@UpdateSeo')->name('update.seo');
    Route::get('admin/seo','Admin\OrderController@seo')->name('admin.seo');

});


Route::middleware(['Report'])->group(function(){
    // Order Report Routes
    Route::get('admin/today/order', 'Admin\ReportController@TodayOrder')->name('today.order');
    Route::get('admin/today/delivery', 'Admin\ReportController@TodayDelivery')->name('today.delivery');
    Route::get('admin/this/month', 'Admin\ReportController@ThisMonth')->name('this.month');
    Route::get('admin/search/report', 'Admin\ReportController@Search')->name('search.report');
    Route::post('admin/search/by/year', 'Admin\ReportController@SearchByYear')->name('search.by.year');
    Route::post('admin/search/by/month', 'Admin\ReportController@SearchByMonth')->name('search.by.month');
    Route::post('admin/search/by/date', 'Admin\ReportController@SearchByDate')->name('search.by.date');
});

Route::middleware(['SiteSetting'])->group(function(){
    // Admin Site Setting Route
    Route::post('admin/sitesetting', 'Admin\SettingController@UpdateSiteSetting')->name('update.sitesetting');
    Route::get('admin/site/setting', 'Admin\SettingController@SiteSetting')->name('admin.site.setting');
});






















Route::get('language/english', 'BlogController@English')->name('language.english');
Route::get('language/arabic', 'BlogController@arabic')->name('language.arabic');
Route::get('blog/single/{id}','BlogController@BlogSingle');
Route::get('blog/post/', 'BlogController@blog')->name('blog.post');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/change-password', 'Auth\ChangePasswordController@index')->name('change.password');
Route::post('/change-password', 'Auth\ChangePasswordController@changepassword')->name('password.update');
Route::get('/user/logout', 'HomeController@logout')->name('user.logout');
//Admin Routes
// to show home page after correct login
Route::get('/admin/home', 'AdminController@index')->name('admin.home');
//to show login form
Route::get('admin', 'Admin\LoginController@showLoginFrom')->name('admin.login');
//to insert email & password to DB
Route::post('/admin', 'Admin\LoginController@login');
//admin ogout
Route::get('admin/logout', 'AdminController@logout')->name('admin.logout');
//admin change password
Route::get('/admin/Change/Password','AdminController@ChangePassword')->name('admin.password.change');
Route::post('/admin/password/update','AdminController@Update_pass')->name('admin.password.update');
// Frontend All Routes
Route::post('store/newslater', 'FrontController@StoreNewslater')->name('store.newslater');
//wish list route
Route::get('add/wishlist/{id}','WishlistController@addwishlist');
//add to cart route
Route::get('add/to/cart/{id}','CartController@AddCart');
Route::get('check','CartController@check');
Route::get('product/details/{id}/{product_name}','ProductController@ProductView');
Route::post('cart/product/add/{id}', 'ProductController@AddCart');
Route::get('product/cart','CartController@ShowCart')->name('show.cart');
Route::get('remove/cart/{rowId}','CartController@removeCart');
Route::post('update/cart/item/', 'CartController@UpdateCart')->name('updete.cartitem');
Route::get('user/checkout/','CartController@Checkout')->name('user.checkout');
Route::get('/cart/product/view/{id}','CartController@ViewProduct');
Route::post('insert/into/cart/', 'CartController@insertCart')->name('insert.into.cart');
Route::get('payment/page', 'CartController@PaymentPage')->name('payment.step');
Route::post('user/payment/process/', 'PaymentController@Payment')->name('payment.process');
Route::post('user/stripe/charge/', 'PaymentController@stripeCharge')->name('stripe.charge');
Route::post('user/stripe/charge/', 'PaymentController@CashCharge')->name('cash.charge');
Route::get('coupon/remove/', 'CartController@CouponRemove')->name('coupon.remove');
Route::post('user/apply/coupon/', 'CartController@Coupon')->name('apply.coupon');
Route::get('user/wishlist/','CartController@Wishlist')->name('user.wishlist');
//Blog Post Route
Route::get('blog/post/', 'BlogController@blog')->name('blog.post');
Route::get('language/english', 'BlogController@English')->name('language.english');
Route::get('language/arabic', 'BlogController@arabic')->name('language.arabic');
Route::get('blog/single/{id}','BlogController@BlogSingle');
//order tracking  route
Route::post('order/tracking', 'FrontController@OrderTraking')->name('order.tracking');
Route::get('order/details/{id}','FrontController@OrderDetails')->name('order.details');
Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');
