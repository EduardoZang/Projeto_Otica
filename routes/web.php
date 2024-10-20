<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VendaController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('produtos', ProdutoController::class);

Route::resource('clientes', ClienteController::class);

Route::resource('vendas', VendaController::class);

//Filtros
Route::post('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
Route::post('/produtos/search', [ProdutoController::class, 'search'])->name('produtos.search');
Route::post('/vendas/search', [VendaController::class, 'search'])->name('vendas.search');