<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // optional stubs (so sidebar links don’t 404 yet)
    Route::view('/contacts', 'stubs.contacts')->name('contacts.index');
    Route::view('/book', 'stubs.book')->name('book.index');
    Route::view('/service', 'stubs.service')->name('service.index');
    Route::view('/leads', 'stubs.leads')->name('leads.index');
    Route::view('/calendar', 'stubs.calendar')->name('calendar.index');
    Route::view('/billing', 'stubs.billing')->name('billing.index');
    Route::view('/settings', 'stubs.settings')->name('settings.index');

    // simple search endpoint you can replace later
    Route::get('/search', [DashboardController::class, 'search'])->name('search');
});
