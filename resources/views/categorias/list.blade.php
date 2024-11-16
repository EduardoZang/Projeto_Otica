@extends('base')
@section('titulo', 'Listagem de Categorias')
@section('conteudo')

<div class="container">
    <h1>Categorias</h1>
    <a href="{{ url('categorias/create') }}" class="btn btn-primary mb-3">Adicionar Categoria</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row mb-4">
        <form action="{{ route('categorias.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-3">
                    <select name="tipo" class="form-select">
                        <option value="nome">Nome</option>
                        <option value="descricao">Descrição</option>
                    </select>
                </div>
                <div class="col-4">
                    <input type="text" name="valor" class="form-control" placeholder="Digite o valor para busca...">
                </div>

                <div class="col-5">
                    <button type="submit" class="btn btn-dark">Buscar</button>
                </div>
            </div>
        </form>
    </div>

    @if($categorias->isEmpty())
        <div class="alert alert-info">Não há nenhuma categoria cadastrada.</div>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nome }}</td>
                        <td>{{ $categoria->descricao }}</td>
                        <td>
                            @if($categoria->imagem)
                                <img src="{{ Storage::url($categoria->imagem) }}" alt="{{ $categoria->nome }}" width="100">
                            @else
                                <span>Sem imagem</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-warning">Editar</a>

                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="post" style="display:inline;">
                                @method('DELETE')
                                @csrf
                                <button type="submit" onclick="return confirm('Deseja remover o registro?')" class="btn btn-dark">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection