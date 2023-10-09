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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KingdomController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');

Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');

Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');


// user Management
Route::get('/users', [UsersController::class, 'index'])->name('user')->middleware('auth');
Route::get('/users/approve/{id}', [UsersController::class, 'approve'])->name('user.approve')->middleware('auth');
Route::get('/users/delete/{id}', [UsersController::class, 'delete'])->name('user.delete')->middleware('auth');
Route::get('/users/reject/{id}', [UsersController::class, 'reject'])->name('user.reject')->middleware('auth');
Route::get('/users/edit/{id}', [UsersController::class, 'show'])->name('user.edit')->middleware('auth');
Route::get('/users/show', [UsersController::class, 'show'])->name('user.show')->middleware('auth');
Route::post('/users', [UsersController::class, 'store'])->name('user.store')->middleware('auth');
Route::post('/users/update', [UsersController::class, 'update'])->name('user.update')->middleware('auth');


// Kingdoms
Route::get('/kingdom', [KingdomController::class, 'index'])->name('kingdom')->middleware('auth');
Route::get('/kingdom/delete', [KingdomController::class, 'delete'])->name('kingdom.delete')->middleware('auth');


// Resource
Route::get('/resources', [ResourcesController::class, 'index'])->name('resource')->middleware('auth');
Route::get('/resources/add',[ResourcesController::class, 'add'])->name('resources.add')->middleware('auth');
Route::post('/resources', [ResourcesController::class, 'store'])->name('resources.store')->middleware('auth');
Route::get('/resources/delete', [ResourcesController::class, 'delete'])->name('resources.delete')->middleware('auth');

// Stock
Route::get('/stock/add',[StockController::class, 'add'])->name('stock.add')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\PageController;
// use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\LoginController;
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\ResetPassword;
// use App\Http\Controllers\ChangePassword;            
            

// Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
// 	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
// 	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
// 	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
// 	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
// 	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
// 	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
// 	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
// 	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
// 	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Route::group(['middleware' => 'auth'], function () {
// 	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
// 	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
// 	Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
// 	Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
// 	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static'); 
// 	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
// 	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static'); 
// 	Route::get('/{page}', [PageController::class, 'index'])->name('page');
// 	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// });