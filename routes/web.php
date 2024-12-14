<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RewardItemController;
use App\Http\Controllers\LogpointController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserpageController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\LogcurrentpointController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ExchangHistoryController;

// Logcurrentpoint
Route::get('/logcurrentpoints', [LogcurrentpointController::class, 'index'])->name('logcurrentpoints');

// History Reward
Route::get('/historyreward', [ExchangHistoryController::class, 'index'])->name('historyreward');
Route::post('/historyreward_status/{id}', [ExchangHistoryController::class, 'updateStatus']);

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::post('/products',[ProductController::class, 'store'])->name('products.store');
Route::delete('/delete_products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::put('/edit_products/{id}', [ProductController::class, 'update'])->name('products.update');

// Member
Route::get('/members', [MemberController::class, 'index'])->name('members');
Route::delete('/delete_members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');
Route::put('/edit_members/{id}', [MemberController::class, 'update'])->name('members.update');
Route::put('/edit_currentpoint/{id}', [MemberController::class, 'updatepoint'])->name('members.updatepoint');

// New Admin
Route::get('/news', [NewController::class, 'index'])->name('news');
Route::post('/news', [NewController::class, 'store'])->name('news.store');
Route::delete('/delete_news/{id}', [NewController::class, 'destroy'])->name('news.destroy');
Route::put('/edit_news/{id}', [NewController::class, 'update'])->name('news.update');

// RewardItem
Route::get('rewarditems', [RewardItemController::class, 'index'])->name('rewarditems');
Route::post('rewarditem', [RewardItemController::class, 'store'])->name('rewarditems.store');
Route::delete('/delete_rewarditems/{id}', [RewardItemController::class, 'destroy'])->name('rewarditems.destroy');
Route::put('/edit_rewarditems/{id}', [RewardItemController::class, 'update'])->name('rewarditems.update');
Route::post('/update_status/{id}', [RewardItemController::class, 'updateStatus']);

// Transactions
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
Route::post('/approve_transaction/{id}', [TransactionController::class,'approve']);
Route::post('/reject_transaction/{id}', [TransactionController::class, 'reject']);

// Machines
Route::get('/machines', [MachineController::class, 'index'])->name('machines');
Route::post('/machines',[MachineController::class, 'store'])->name('machines.store');
Route::delete('/delete_machines/{id}', [MachineController::class, 'destroy'])->name('machines.destroy');
Route::put('/edit_machines/{id}', [MachineController::class, 'update'])->name('machines.update');

// Reward User
Route::get('/reward',[UserpageController::class, 'reward_user'])->name('rewards');
Route::post('/reward', [UserpageController::class, 'exchange_add'])->name('reward.exchange_add');
// Profile User
Route::get('/profile/{id}',[UserpageController::class,'member_user']);
Route::put('/edit_profile/{id}',[UserpageController::class,'edit_profile'])->name('profile.edit_profile');
// Point User
Route::get('/mypoint/{id}', [UserpageController::class, 'point_user']);
// Exchange User
Route::get('/exchange_history/{id}', [UserpageController::class, 'exchang_history_user']);
// Address
Route::post('/profile',[UserpageController::class, 'add_address'])->name('profile.add_address');
Route::delete('/profile/{id}', [UserpageController::class, 'delete_address'])->name('profile.delete_address');
Route::put('/profile/{id}', [UserpageController::class, 'update_address'])->name('profile.update_address');
Route::post('/profile/{id}', [UserpageController::class, 'setAddressDefault']);
// New Detail
Route::get('/new/{id}', [UserpageController::class, 'detail_new'])->name('new.detail');

// ContentAdmin
Route::get('/contract_admin', function () {
    return view('user/contract_admin');
});

// Log Point
Route::get('/logpoints', [LogpointController::class, 'index'])->name('logpoints');

// Login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register']);

// Reset Password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Verify Email
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware('auth')
    ->name('verification.send');
// Middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/new', [UserpageController::class, 'news'])->middleware('check.level:1')->name('user.new');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('check.level:2')->name('admin.dashboard');
});

Auth::routes();
