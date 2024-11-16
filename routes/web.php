<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FuncionarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('produtos', ProdutoController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('vendas', VendaController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('funcionarios', FuncionarioController::class);

// Filtros
Route::post('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
Route::post('/produtos/search', [ProdutoController::class, 'search'])->name('produtos.search');
Route::post('/vendas/search', [VendaController::class, 'search'])->name('vendas.search');
Route::post('/categorias/search', [CategoriaController::class, 'search'])->name('categorias.search');
Route::post('/funcionarios/search', [FuncionarioController::class, 'search'])->name('funcionarios.search');

//Relatórios
Route::get('/produtos/relatorio', [ProdutoController::class, 'gerarRelatorio'])->name('produtos.relatorio');
Route::get('/vendas/relatorio', [VendaController::class, 'gerarRelatorio'])->name('vendas.relatorio');