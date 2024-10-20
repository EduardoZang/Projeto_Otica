@extends('base')
@section('titulo', isset($produto) ? 'Editar Produto' : 'Adicionar Produto')
@section('conteudo')

<div class="container">
    <h1>{{ isset($produto) ? 'Editar Produto' : 'Adicionar Produto' }}</h1>
    <form action="{{ isset($produto) ? route('produtos.update', $produto->id) : route('produtos.store') }}" method="POST">
        @csrf
        @if (isset($produto))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" name="descricao" id="descricao" value="{{ old('descricao', isset($produto) ? $produto->descricao : '') }}" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="number" step="0.01" class="form-control" name="preco" id="preco" value="{{ old('preco', isset($produto) ? $produto->preco : '') }}" required>
        </div>

        <div class="form-group">
            <label for="estoque">Estoque</label>
            <input type="number" class="form-control" name="estoque" id="estoque" value="{{ old('estoque', isset($produto) ? $produto->estoque : '') }}" required>
        </div>

        <button type="submit" class="btn btn-success mb-3 mt-3">{{ isset($produto) ? 'Atualizar' : 'Adicionar' }}</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary mb-3 mt-3">Cancelar</a>
    </form>
</div>
@endsection