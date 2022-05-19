<?php

use App\Http\Controllers\Shopper\ShopperQueueController;
use App\Http\Controllers\Store\Location\LocationController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;

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

Route::name('index')
    ->get('/index', [StoreController::class, 'index']);

Route::name('create')
    ->get('/create', [StoreController::class, 'create']);

Route::name('save')
    ->post('/create', [StoreController::class, 'store']);

Route::name('store')
    ->get('/{store}', [StoreController::class, 'show']);

Route::name('locations')
    ->get('/locations/{store}', [ShopperQueueController::class, 'storeLocations']);

Route::name('markAsComplete')
    ->get('/markAsComplete/{shopperUuid}', [ShopperQueueController::class, 'markAsComplete']);
Route::name('location.update')
    ->put('/location/update/{id}', [LocationController::class, 'update']);

Route::namespace('Location')
    ->prefix('{storeUuid}/location')
    ->name('location.')
    ->group(__DIR__ . '/Location/web.php');
