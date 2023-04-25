<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

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

// Declaro a uri inicial das requisições dos produtos
$prodUri = '/products';

// Modelo a rota de Atualização de um produto
Route::put($prodUri . '/{code}', [ProductController::class, 'update']);

// Modelo a rota de Remoção de um produto
Route::delete($prodUri . '/{code}', [ProductController::class, 'destroy']);