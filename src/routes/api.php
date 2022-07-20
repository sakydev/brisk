<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// get route for / 
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the API',
        'status' => 'success',
    ]);
});

Route::prefix('/v1')->group(function () {
    Route::prefix('videos')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('list_videos');
        Route::post('/', [VideoController::class, 'store'])->name('store_video');
        
        
        Route::post('/{video}', [VideoController::class, 'update'])->name('update_video');
        Route::get('/{video}', [VideoController::class, 'show'])->name('show_video');
        Route::delete('/{video}', [VideoController::class, 'destroy'])->name('destroy_video');
    });
});