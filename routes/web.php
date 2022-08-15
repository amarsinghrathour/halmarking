<?php

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

//Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home1');
Route::get('/','App\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::get('/home', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
##################
# Website Routes
##################
Route::get('/gallery/{slug}', [App\Http\Controllers\Web\HomeController::class, 'galleryView'])->name('web.gallery.view');
Route::get('/notice/{slug}', [App\Http\Controllers\Web\HomeController::class, 'noticeView'])->name('web.notice.view');
Route::get('/upcoming-event/{slug}', [App\Http\Controllers\Web\HomeController::class, 'upcomingEventView'])->name('web.upcoming_event.view');
Route::get('/recent-activity/{slug}', [App\Http\Controllers\Web\HomeController::class, 'recentActivityView'])->name('web.recent_activity.view');
Route::get('/service/{slug}', [App\Http\Controllers\Web\HomeController::class, 'serviceView'])->name('web.service.view');
Route::get('/blog/category/{slug}', [App\Http\Controllers\Web\HomeController::class, 'blogByCategory'])->name('web.blog.category');
Route::any('/blog', [App\Http\Controllers\Web\HomeController::class, 'blog'])->name('web.blog.list');
Route::any('/product/{slug}', [App\Http\Controllers\Web\HomeController::class, 'productDetail'])->name('web.product.view');
Route::post('/enquiry-form-save', [App\Http\Controllers\Web\HomeController::class, 'enquiryFormSave'])->name('web.enquiry.form.save');
Route::any('/shop', [App\Http\Controllers\Web\HomeController::class, 'shop'])->name('web.shop');

#####################
# Admin Routes
##################
Route::group(["namespace"=>"App\Http\Controllers\Admin","prefix"=>Config('app.admin_prefix'),'middleware' => ['assign.guard:admin']], function(){
    include 'admin.php';
});
 Route::group(["prefix"=>Config('app.admin_prefix'),'middleware' => ['auth:admin']], function()
{ 
Route::get('/apilogs', 'AWT\Http\Controllers\ApiLogController@index')->name("apilogs.index");

Route::delete('/apilogs/delete', 'AWT\Http\Controllers\ApiLogController@delete')->name("apilogs.deletelogs");
});



//this catches the All the domains and all their pages:
Route::any('{all}', [App\Http\Controllers\Web\HomeController::class, 'index'])->where('all', '^(?!admin).*$')->name('web.page');
//Route::any('{all}', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('web.page');

