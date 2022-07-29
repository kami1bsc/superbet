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
    return view('auth.login');
});

Auth::routes();

Route::get('admin-logout', function(){
	\Auth::logout();

	return redirect()->route('login');
})->name('admin-logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('privacy_policy', function(){
    return view('privacy_policy'); 
});

Route::get('terms_and_conditions', function(){
    return view('terms_and_conditions'); 
});

Route::get('contact-us', function(){
    return view('contact_us');
});

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    //define routes here for admin
    Route::get('/', [App\Http\Controllers\Admin\AdminNavigationController::class, 'dashboard'])->name('dashboard');	
    Route::resource('users', App\Http\Controllers\Admin\AllUserController::class); 	
    Route::get('edit_user/{user_id}', [App\Http\Controllers\Admin\AdminNavigationController::class, 'edit_user'])->name('edit_user');
    Route::post('update_user', [App\Http\Controllers\Admin\AdminNavigationController::class, 'update_user'])->name('update_user');
});

Route::group([ 'prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    Route::get('/', [App\Http\Controllers\Users\UserNavigationController::class, 'dashboard'])->name('dashboard');	
	//define routes here for user
});
