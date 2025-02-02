<?php

use Illuminate\Support\Facades\Route;

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
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ProviderController;
use App\Livewire\SortButton;
use App\Livewire\CreatePost;
use App\Livewire\Upvote;
use App\Models\User;

Route::get('/home', function () {
    return redirect('/dashboard');
})->middleware('auth')->name('home');
Route::get('/index', function () {
    return redirect('/dashboard');
})->middleware('auth')->name('index');
// GOOGLE LOG IN API
Route::get('/auth/google/redirect', [ProviderController::class,'redirect']);
Route::get('/auth/google/callback', [ProviderController::class,'callback']);
// END GOOGLE LOG IN API
Route::get('/suspended', [PostController::class, 'suspended'])->middleware('suspended')->name('suspended');
// Route::get('/', App\Livewire\SortButton::class);
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {return redirect('/dashboard');})->name('home');
});
// Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [PostController::class, 'index'])->middleware('auth')->name('home');
Route::get('/post/{post}', [PostController::class, 'show'])->middleware('auth')->name('show');
Route::get('/warning', [PostController::class, 'warning'])->middleware('auth')->name('warning');
Route::get('/archives', [PostController::class, 'archives'])->middleware('auth')->name('archives');
Route::get('/category/{category}', [PostController::class, 'CategoryShow'])->middleware('auth')->name('categories');
Route::get('/categories', [PostController::class, 'AllCategories'])->middleware('auth')->name('allcategories');
Route::get('/tag/{tag}', [PostController::class, 'allTags'])->middleware('auth')->name('tags');
Route::get('/announcement/{announcement}', [PostController::class, 'AnnouncementShow'])->middleware('auth')->name('announcements');
Route::get('/welcome', [PostController::class, 'firstLogin'])->middleware('auth')->name('welcome');
Route::post('/welcome', [PostController::class, 'firstLoginUpdate'])->middleware('auth')->name('welcome.update');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile/{id}', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile/{id}', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});


