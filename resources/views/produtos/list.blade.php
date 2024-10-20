@extends('base')
@section('titulo', 'Listagem de Produtos')
@section('conteudo')

<div class="container">
    <h1>Produtos</h1>
    <a href="{{ url('produtos/create') }}" class="btn btn-primary mb-3">Adicionar Produto</a>

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
        <form action="{{ route('produtos.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-3">
                    <select name="tipo" class="form-select">
                        <option value="descricao">Descrição</option>
                        <option value="preco">Preço</option>
                        <option value="estoque">Estoque</option>
                        <option value="cliente">Comissão</option>
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

    @if($produtos->isEmpty())
        <div class="alert alert-info">Não há nenhum produto cadastrado.</div>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Comissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->id }}</td>
                        <td>{{ $produto->descricao }}</td>
                        <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td>{{ $produto->estoque }}</td>
                        <td>{{$produto->cliente->nome}}</td>
                        <td>
                            <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning">Editar</a>
                            
                            <form action="{{ route('produtos.destroy', $produto->id) }}" method="post" style="display:inline;">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Deseja remover o registro?')" class="btn btn-dark">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection