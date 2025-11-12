<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes — Agency Builder CRM
|--------------------------------------------------------------------------
|
| These routes handle all authenticated user access to the CRM’s
| main interface (Tier 1: Individual Agent). Legacy includes
| (dashboard.php, etc.) have been removed to ensure all views
| are rendered via Blade.
|
*/

Route::middleware(['web', 'auth'])->group(function () {

    // Redirect root URL → /dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    | Main agent dashboard — dynamic data rendered from DashboardController.
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Core CRM Modules (placeholders for now)
    |--------------------------------------------------------------------------
    | Each of these corresponds to a sidebar tab.
    | You can replace stubs with actual controllers later.
    */
    Route::view('/contacts', 'stubs.contacts')->name('contacts.index');
    Route::view('/book', 'stubs.book')->name('book.index');
    Route::view('/service', 'stubs.service')->name('service.index');
    Route::view('/leads', 'stubs.leads')->name('leads.index');
    Route::view('/calendar', 'stubs.calendar')->name('calendar.index');
    Route::view('/billing', 'stubs.billing')->name('billing.index');
    Route::view('/settings', 'stubs.settings')->name('settings.index');

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    | Simple search endpoint for global search bar (clients, leads, etc.).
    */
    Route::get('/search', [DashboardController::class, 'search'])->name('search');

    /*
    |--------------------------------------------------------------------------
    | Activity Log (optional)
    |--------------------------------------------------------------------------
    | You can later connect this to an ActivityController.
    */
    Route::view('/activity', 'stubs.activity')->name('activity.index');
});

/*
|--------------------------------------------------------------------------
| Authentication Redirects (unauthenticated users)
|--------------------------------------------------------------------------
| Prevents unauthorized access to the dashboard.
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::fallback(function () {
    return redirect()->route('dashboard');
});
