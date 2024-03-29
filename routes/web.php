<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\TrackingCookieController;
use App\Mail\MonthlyNewsletter;
use App\Models\User;
use Illuminate\Http\Request;

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


Route::middleware(['throttle:global'])->group(function () {

    // Home page
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Posts
    Route::resource('posts', PostController::class)->except('show', 'index')->middleware(['auth', 'email.verified']);
    Route::resource('posts', PostController::class)->only('show', 'index');

    // Users
    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => 'auth'], function () {
        Route::get('/{locale}/local', [UserController::class, 'locale'])->name('locale');
        Route::get('/{user}/posts', [UserController::class, 'posts'])->name('posts');
    });

    // Authentication
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::group(['middleware' => ['guest']], function () {
            Route::get('/sign-up',  [AuthController::class, 'create'])->name('create');
            Route::post('/sign-up',  [AuthController::class, 'store'])->name('store');

            Route::group(['prefix' => 'login'], function () {
                Route::get('/', [AuthController::class, 'login'])->name('login');
                Route::post('/', [AuthController::class, 'authenticate'])->name('authenticate');
            });

            Route::get('/google', [GoogleLoginController::class, 'redirect'])->name('google_redirect');
            Route::get('/google/callback', [GoogleLoginController::class, 'callback'])->name('google_callback');
        });
        Route::post('/logout',  [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    });

    // Password reset
    Route::group(['prefix' => 'password-reset', 'middleware' => 'guest', 'as' => 'password.'], function () {
        Route::get('/forgot-password',  [PasswordResetController::class, 'request'])->name('request');
        Route::post('/forgot-password',  [PasswordResetController::class, 'email'])->name('email');
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('reset');
        Route::post('/reset-password',  [PasswordResetController::class, 'update'])->name('update');
    });

    // Email verification
    Route::group(['prefix' => 'email-verification', 'middleware' => 'auth', 'as' => 'verification.'], function () {
        Route::get('/verify',  [EmailVerificationController::class, 'notice'])->name('notice');
        Route::get('/verify/{id}/{hash}',  [EmailVerificationController::class, 'verify'])->name('verify');
        Route::post('/notification',  [EmailVerificationController::class, 'send'])->middleware('throttle:6,1')->name('send');
    });

    // Payments
    Route::group(['prefix' => 'payment', 'middleware' => 'auth', 'as' => 'payment.'], function () {
        Route::get('/{post}', [PaymentController::class, 'charge'])->middleware('auth')->name('charge');
        Route::post('/process-payment/{post}/', [PaymentController::class, 'process'])->middleware('auth')->name('process');
    });

    // Tracking
    Route::get('/track/allow', [TrackingCookieController::class, 'allow'])->name('track.allow');
});


if (config('app.env') == 'development') {
    Route::get('/mailable', function () {
        $user = User::find(1);

        return new MonthlyNewsletter($user);
    });
}


Route::get('/billing-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal();
});
