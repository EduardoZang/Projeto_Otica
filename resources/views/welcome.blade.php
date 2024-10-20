@extends('base')
@section('titulo', 'Página Inicial')

@section('conteudo')
    <div class="container mt-5">
        <h1 class="text-center">Bem-vinda (o) à Ótica Olhar Feliz</h1>
        <p class="text-center">Este é um sistema simples para gerenciar produtos, clientes e vendas.</p>
        <div class="text-center mt-4">
            <a href="{{ route('produtos.index') }}" class="btn btn-primary">Gerenciar Produtos</a>
            <a href="{{ route('clientes.index') }}" class="btn btn-success">Gerenciar Clientes</a>
            <a href="{{ route('vendas.index') }}" class="btn btn-warning">Gerenciar Vendas</a>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>