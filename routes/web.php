<?php
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PointsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/peta', [PageController::class, 'peta'])->name('peta');
Route::get('/tabel', [PageController::class, 'tabel'])->name('tabel');

Route::post('/points', [PointsController::class, 'store'])
    ->name('points.store');
Route::delete('/delete-points/{id}', [PointsController::class, 'destroy'])
    ->name('points.delete');
Route::get('/edit-point/{id}', [PointsController::class, 'edit'])
    ->name('point.edit');
Route::patch('/update-point/{id}', [PointsController::class, 'update'])
    ->name('point.update');
Route::post('/polylines', [PolylinesController::class, 'store'])
    ->name('polylines.store');
Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])
    ->name('polylines.delete');
Route::get('/edit-polylines/{id}', [PointsController::class, 'edit'])
    ->name('polylines.edit');
Route::patch('/update-polylines/{id}', [PointsController::class, 'update'])
    ->name('polylines.update');
Route::post('/polygons', [PolygonsController::class, 'store'])
    ->name('polygons.store');
Route::delete('/delete-polygons/{id}', [PolygonsController::class, 'destroy'])
    ->name('polygons.delete');
Route::get('/edit-polygon/{id}', [PolygonsController::class, 'edit'])
    ->name('polygon.edit');
Route::patch('/update-polygon/{id}', [PolygonsController::class, 'update'])
    ->name('polylgon.update');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
