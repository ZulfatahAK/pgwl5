<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/points', [ApiController::class, 'geojson_points'])->name('geojson.points');
Route::get('/point/{id}', [ApiController::class, 'geojson_point'])->name('geojson.point');
Route::get('/polylines', [ApiController::class, 'geojson_polylines'])->name('geojson.polylines');
Route::get('/polyline/{id}', [ApiController::class, 'geojson_polyline'])->name('geojson.polyline');
Route::get('/polygons', [ApiController::class, 'geojson_polygons'])->name('geojson.polygons');
Route::get('/polygon/{id}', [ApiController::class, 'geojson_polygon'])->name('geojson.polygon');
