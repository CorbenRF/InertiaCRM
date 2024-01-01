<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\CuratorsController;
use App\Http\Controllers\InspectorsController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\SubvendorsController;
use App\Http\Controllers\CataloguesController;
use App\Http\Controllers\HistoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/history', function () {
//     return Inertia::render('History');
// })->middleware(['auth', 'verified'])->name('history');

// Route::get('/catalogues', function () {
//     return Inertia::render('Catalogues');
// })->middleware(['auth', 'verified'])->name('catalogues');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('history', [HistoryController::class, 'index'])
    ->name('history')
    ->middleware('auth');

    Route::get('catalogues', [CataloguesController::class, 'index'])
    ->name('catalogues')
    ->middleware('auth');
// Entries

Route::get('entries', [EntryController::class, 'index'])
    ->name('entries')
    ->middleware('auth');

Route::get('entries/create', [EntryController::class, 'create'])
    ->name('entries.create')
    ->middleware('auth');

Route::post('entries', [EntryController::class, 'store'])
    ->name('entries.store')
    ->middleware('auth');

Route::get('entries/{entry}/edit', [EntryController::class, 'edit'])
    ->name('entries.edit')
    ->middleware('auth');

Route::put('entries/{entry}', [EntryController::class, 'update'])
    ->name('entries.update')
    ->middleware('auth');

Route::delete('entries/{entry}', [EntryController::class, 'destroy'])
    ->name('entries.destroy')
    ->middleware('auth');

// entries end

// Clients

Route::get('clients', [ClientsController::class, 'index'])
    ->name('clients')
    ->middleware('auth');

Route::get('clients/create', [ClientsController::class, 'create'])
    ->name('clients.create')
    ->middleware('auth');

Route::post('clients', [ClientsController::class, 'store'])
    ->name('clients.store')
    ->middleware('auth');

Route::get('clients/{client}/edit', [ClientsController::class, 'edit'])
    ->name('clients.edit')
    ->middleware('auth');

Route::put('clients/{client}', [ClientsController::class, 'update'])
    ->name('clients.update')
    ->middleware('auth');

Route::delete('clients/{client}', [ClientsController::class, 'destroy'])
    ->name('clients.destroy')
    ->middleware('auth');


require __DIR__.'/auth.php';