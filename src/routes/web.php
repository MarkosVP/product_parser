<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

// Modelo a rota base do app
Route::get('/', [AppController::class, 'basePath']);

// Habilito a rota do PHp no ambiente de Dev apenas
if (env('APP_ENV', 'prod') == 'dev') {
    // Modelo a rota base do app para o php
    Route::get('/php', [AppController::class, 'basePHP']);
}

// Modelo a rota da página principal
Route::get('/home', [HomeController::class, 'home']);

// Declaro a uri inicial das requisições dos produtos
$prodUri = '/products';

// Modelo a rota de consulta dos produtos
Route::get($prodUri, [ProductController::class, 'index']);

// Modelo a rota de consulta de um produto em específico
Route::get($prodUri . '/{code}', [ProductController::class, 'show']);

// Modelo a rota de Atualização de um produto
Route::put($prodUri . '/{code', [ProductController::class, 'update']);

// Modelo a rota de Remoção de um produto
Route::delete($prodUri . '/{code', [ProductController::class, 'destroy']);

// Modelo a rota da Cron dos produtos
Route::get('/productCron', [CronController::class, 'execute']);