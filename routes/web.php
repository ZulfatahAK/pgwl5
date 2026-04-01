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
Route::post('/polylines', [PolylinesController::class, 'store'])
->name('polylines.store');
Route::post('/polygons', [PolygonsController::class, 'store'])
->name('polygons.store');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
