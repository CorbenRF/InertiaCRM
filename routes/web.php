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
//     return Inertia::render('Catalogues/Index');
// })->middleware('auth')->name('catalogues');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('catalogues', [CataloguesController::class, 'index'])
    ->name('catalogues')
    ->middleware('auth');

Route::get('catalogues/get', [CataloguesController::class, 'get'])
->name('catalogues.get')
->middleware('auth');

// here i define all of the update paths for each individual catalogue

Route::put('Client/{client}', [ClientsController::class, 'update'])
    ->name('clients.update')
    ->middleware('auth');

Route::put('Department/{department}', [DepartmentsController::class, 'update'])
->name('departments.update')
->middleware('auth');

Route::put('Vendor/{vendor}', [VendorsController::class, 'update'])
    ->name('vendors.update')
    ->middleware('auth');

Route::put('Subvendor/{subvendor}', [SubvendorsController::class, 'update'])
->name('Subvendors.update')
->middleware('auth');

Route::put('Inspector/{inspector}', [InspectorsController::class, 'update'])
->name('inspectors.update')
->middleware('auth');

Route::put('Curator/{curator}', [CuratorsController::class, 'update'])
    ->name('curators.update')
    ->middleware('auth');

Route::put('Status/{status}', [StatusesController::class, 'update'])
->name('statuses.update')
->middleware('auth');

// END OF CATALOGUES UPDATE SECTION

// here i define all of the delete paths for each individual catalogue

Route::delete('Client/{client}', [ClientsController::class, 'destroy'])
    ->name('clients.delete')
    ->middleware('auth');

Route::delete('Department/{department}', [DepartmentsController::class, 'destroy'])
->name('departments.delete')
->middleware('auth');

Route::delete('Vendor/{vendor}', [VendorsController::class, 'destroy'])
    ->name('vendors.delete')
    ->middleware('auth');

Route::delete('Subvendor/{subvendor}', [SubvendorsController::class, 'destroy'])
->name('subvendors.delete')
->middleware('auth');

Route::delete('Inspector/{inspector}', [InspectorsController::class, 'destroy'])
->name('inspectors.delete')
->middleware('auth');

Route::delete('Curator/{curator}', [CuratorsController::class, 'destroy'])
    ->name('curators.delete')
    ->middleware('auth');

Route::delete('Status/{status}', [StatusesController::class, 'destroy'])
->name('statuses.delete')
->middleware('auth');

// END OF CATALOGUES delete SECTION



Route::get('history', [HistoryController::class, 'index'])
    ->name('history')
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

Route::get('entries/{entry}/isbusy', [EntryController::class, 'isbusy'])
->name('entries.isbusy')
->middleware('auth');

Route::post('entries/makebusy', [EntryController::class, 'makebusy'])
->name('entries.makebusy')
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


Route::get('curators', [CuratorsController::class, 'index'])
->name('curators')
->middleware('auth');
Route::post('curators', [CuratorsController::class, 'store'])
->name('curators.store')
->middleware('auth');

Route::get('departments', [DepartmentsController::class, 'index'])
->name('departments')
->middleware('auth');
Route::post('departments', [DepartmentsController::class, 'store'])
->name('departments.store')
->middleware('auth');

Route::get('inspectors', [InspectorsController::class, 'index'])
->name('inspectors')
->middleware('auth');
Route::post('inspectors', [InspectorsController::class, 'store'])
->name('inspectors.store')
->middleware('auth');

Route::get('statuses', [StatusesController::class, 'index'])
->name('statuses')
->middleware('auth');
Route::post('statuses', [StatusesController::class, 'store'])
->name('statuses.store')
->middleware('auth');

Route::get('vendors', [VendorsController::class, 'index'])
    ->name('vendors')
    ->middleware('auth');
Route::post('vendors', [VendorsController::class, 'store'])
->name('vendors.store')
->middleware('auth');

Route::get('subvendors', [SubvendorsController::class, 'index'])
->name('subvendors')
->middleware('auth');
Route::post('subvendors', [SubvendorsController::class, 'store'])
->name('subvendors.store')
->middleware('auth');

// here i define all of the post/create-new paths for each individual catalogue
Route::get('Client', [ClientsController::class, 'index'])
->name('clients')
->middleware('auth');
Route::post('Client', [ClientsController::class, 'store'])
->name('clients.store')
->middleware('auth');

Route::get('Department', [DepartmentsController::class, 'index'])
->name('departments')
->middleware('auth');
Route::post('Department', [DepartmentsController::class, 'store'])
->name('departments.store')
->middleware('auth');

Route::get('Vendor', [VendorsController::class, 'index'])
->name('vendors')
->middleware('auth');
Route::post('Vendor', [VendorsController::class, 'store'])
    ->name('vendors.store')
    ->middleware('auth');

Route::get('Subvendor', [SubvendorsController::class, 'index'])
->name('subvendors')
->middleware('auth');
Route::post('Subvendor', [SubvendorsController::class, 'store'])
->name('subvendors.store')
->middleware('auth');

Route::get('Inspector', [InspectorsController::class, 'index'])
->name('inspectors')
->middleware('auth');
Route::post('Inspector', [InspectorsController::class, 'store'])
->name('inspectors.store')
->middleware('auth');

Route::get('Curator', [CuratorsController::class, 'index'])
->name('curators')
->middleware('auth');
Route::post('Curator', [CuratorsController::class, 'store'])
->name('curators.store')
->middleware('auth');

Route::get('Status', [StatusesController::class, 'index'])
->name('statuses')
->middleware('auth');
Route::post('Status', [StatusesController::class, 'store'])
->name('statuses.store')
->middleware('auth');

// END OF CATALOGUES post/create-new SECTION

require __DIR__.'/auth.php';
