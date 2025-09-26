<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/bills/{bill}/participants', [BillParticipantController::class, 'store'])
    ->name('bills.participants.store');

// Email Verification Routes
Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Guest Routes (Publicly accessible)
Route::get('/join', [GuestController::class, 'showJoinForm'])->name('guest.join.form');
Route::post('/guest/join', [GuestController::class, 'join'])->name('guest.join');

// Authenticated Routes (Requires both auth and verified email)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - Redirect to bills index
    Route::get('/dashboard', function () {
        return redirect()->route('bills.index');
    })->name('dashboard');

    // Bills
    Route::resource('bills', BillController::class);
    Route::get('/bills/archived', [BillController::class, 'archived'])->name('bills.archived');
    Route::post('/bills/{bill}/archive', [BillController::class, 'archive'])->name('bills.archive');
    Route::post('/bills/{bill}/unarchive', [BillController::class, 'unarchive'])->name('bills.unarchive');
    Route::post('/bills/{bill}/regenerate', [BillController::class, 'regenerateCode'])->name('bills.regenerate');
    Route::post('/bills/{bill}/add-participant', [BillController::class, 'addParticipant'])->name('bills.addParticipant');
    Route::get('/bills/generate-code', [BillController::class, 'generateCode'])->name('bills.generate-code');
    
    // Bill show route with guest access middleware
    Route::get('/bills/{bill}', [BillController::class, 'show'])
        ->name('bills.show')
        ->middleware('guest.bill');

    // Expenses
    Route::get('/bills/{bill}/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::resource('expenses', ExpenseController::class)->except(['index', 'create', 'show']);
    
    // Categories
    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('categories.store');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upgrade', [ProfileController::class, 'upgradeAccount'])->name('profile.upgrade');
    Route::get('/bills/generate-code', [BillController::class, 'generateCode'])->name('bills.generate-code');
    Route::post('/bills/generate-code', [BillController::class, 'generateCode'])->name('bills.generate-code');
    // Make sure you have these routes defined:
Route::resource('bills', BillController::class)->middleware('auth');
Route::get('/bills/{bill}', [BillController::class, 'show'])->name('bills.show');
Route::get('/guest/bill', [BillController::class, 'guestView'])->name('guest.bill');
Route::get('/guest/bill/{bill}', [BillController::class, 'guestShow'])->name('guest.bill.show');
});