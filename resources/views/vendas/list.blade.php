@extends('base')
@section('titulo', 'Listagem de Vendas')
@section('conteudo')

<div class="container">
    <h1>Vendas</h1>
    
    <a href="{{ route('vendas.create') }}" class="btn btn-primary mb-3">Adicionar Venda</a>

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
        <form action="{{ route('vendas.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-3">
                    <select name="tipo" class="form-select">
                        <option value="cliente">Cliente</option>
                        <option value="produto">Produto</option>
                        <option value="quantidade">Quantidade</option>
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
    <div class="mb-3">
        <a target="_blank" href="{{ route('vendas.relatorio') }}" class="btn btn-info">Gerar Relatório</a>
    </div>

    @if($vendas->isEmpty())
        <div class="alert alert-info">Não há nenhuma venda registrada.</div>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Funcionário</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendas as $venda)
                    <tr>
                        <td>{{ $venda->id }}</td>
                        <td>{{ $venda->cliente->nome }}</td>
                        <td>{{ $venda->produto->descricao }}</td>
                        <td>{{ $venda->funcionario ? $venda->funcionario->nome : 'Sem funcionário' }}</td>
                        <td>{{ $venda->quantidade }}</td>
                        <td>
                            <a href="{{ route('vendas.edit', $venda->id) }}" class="btn btn-warning">Editar</a>
                            
                            <form action="{{ route('vendas.destroy', $venda->id) }}" method="post" style="display:inline;">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-dark" 
                                    onclick="return confirm('Deseja remover esta venda?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection