@extends('base')
@section('titulo', isset($categoria) ? 'Editar Categoria' : 'Adicionar Categoria')
@section('conteudo')

<div class="container">
    <h1>{{ isset($categoria) ? 'Editar Categoria' : 'Adicionar Categoria' }}</h1>
    <form action="{{ isset($categoria) ? route('categorias.update', $categoria->id) : route('categorias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($categoria))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nome">Nome da Categoria</label>
            <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', isset($categoria) ? $categoria->nome : '') }}" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" name="descricao" id="descricao" required>{{ old('descricao', isset($categoria) ? $categoria->descricao : '') }}</textarea>
        </div>

        @if (isset($categoria) && $categoria->imagem)
            <div class="form-group">
                <label for="imagem">Imagem Atual</label><br>
                <img src="{{ asset('storage/' . $categoria->imagem) }}" alt="$categoria->nome" style="max-width: 200px; max-height: 200px;">
                <br>
            </div>
        @endif

        <div class="form-group">
            <label for="imagem">Nova Imagem</label>
            <input type="file" class="form-control" name="imagem" id="imagem">
        </div>

        <button type="submit" class="btn btn-success mb-3 mt-3">{{ isset($categoria) ? 'Atualizar' : 'Adicionar' }}</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary mb-3 mt-3">Cancelar</a>
    </form>
</div>

@endsection