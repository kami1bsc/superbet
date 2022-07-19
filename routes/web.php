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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('admin-logout', function(){
	\Auth::logout();

	return redirect()->route('login');
})->name('admin-logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    //define routes here for admin
    Route::get('/', [App\Http\Controllers\Admin\AdminNavigationController::class, 'dashboard'])->name('dashboard');	
    Route::resource('users', App\Http\Controllers\Admin\AllUserController::class); 	
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class); 	
	Route::resource('albums', App\Http\Controllers\Admin\AlbumController::class); 
    Route::get('delete_album/{album_id}', [App\Http\Controllers\Admin\AlbumController::class, 'delete_album'])->name('delete_album'); 
    Route::resource('videos', App\Http\Controllers\Admin\VideoController::class); 
    Route::get('delete_video/{video_id}', [App\Http\Controllers\Admin\VideoController::class, 'delete_video'])->name('delete_video'); 
    Route::resource('majlis', App\Http\Controllers\Admin\MajlisUpdateController::class); 
    Route::get('delete_majlis/{majlis_id}', [App\Http\Controllers\Admin\MajlisUpdateController::class, 'delete_majlis'])->name('delete_majlis');
    Route::resource('banners', App\Http\Controllers\Admin\BannerImagesController::class); 
    Route::resource('top-section', App\Http\Controllers\Admin\TopSectionController::class); 
    Route::get('month', [App\Http\Controllers\Admin\MonthKalamController::class, 'month'])->name('month');
    Route::get('edit_month/{month_id}', [App\Http\Controllers\Admin\MonthKalamController::class, 'edit_month'])->name('edit_month');
    Route::post('update_month', [App\Http\Controllers\Admin\MonthKalamController::class, 'update_month'])->name('update_month');
    Route::resource('month-kalam', App\Http\Controllers\Admin\MonthKalamController::class); 
    Route::resource('trending', App\Http\Controllers\Admin\TrendingController::class);
    Route::resource('nohay-singles', App\Http\Controllers\Admin\NohaySingleController::class); 
    Route::resource('manqabat-singles', App\Http\Controllers\Admin\ManqabatSingleController::class); 
});

Route::group([ 'prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    Route::get('/', [App\Http\Controllers\Users\UserNavigationController::class, 'dashboard'])->name('dashboard');	
	//define routes here for user
});
