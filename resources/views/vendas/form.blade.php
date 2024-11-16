@extends('base')
@section('titulo', isset($venda) ? 'Editar Venda' : 'Adicionar Venda')
@section('conteudo')

    <div class="container">
        <h1>{{ isset($venda) ? 'Editar Venda' : 'Adicionar Venda' }}</h1>
        <form action="{{ isset($venda) ? route('vendas.update', $venda->id) : route('vendas.store') }}" method="POST">
            @csrf
            @if (isset($venda))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select class="form-control" name="cliente_id" id="cliente_id" required>
                    <option value="" disabled {{ !isset($venda) ? 'selected' : '' }}>Selecione</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id', isset($venda) ? $venda->cliente_id : '') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="produto_id">Produto</label>
                <select class="form-control" name="produto_id" id="produto_id" required>
                    <option value="" disabled {{ !isset($venda) ? 'selected' : '' }}>Selecione</option>
                    @foreach ($produtos as $produto)
                        <option value="{{ $produto->id }}" {{ old('produto_id', isset($venda) ? $venda->produto_id : '') == $produto->id ? 'selected' : '' }}>
                            {{ $produto->descricao }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
            <label for="funcionario_id">Funcionário</label>
            <select class="form-control" name="funcionario_id" id="funcionario_id" required>
                <option value="" disabled {{ !isset($venda) ? 'selected' : '' }}>Selecione</option>
                @foreach ($funcionarios as $funcionario)
                    <option value="{{ $funcionario->id }}" {{ old('funcionario_id', isset($venda) ? $venda->funcionario_id : '') == $funcionario->id ? 'selected' : '' }}>
                        {{ $funcionario->nome }}
                    </option>
                @endforeach
            </select>
        </div>

            <div class="form-group">
                <label for="quantidade">Quantidade</label>
                <input type="number" class="form-control" name="quantidade" id="quantidade" value="{{ old('quantidade', isset($venda) ? $venda->quantidade : '') }}" required>
            </div>

            <button type="submit" class="btn btn-success mb-3 mt-3">{{ isset($venda) ? 'Atualizar' : 'Adicionar' }}</button>
            <a href="{{ route('vendas.index') }}" class="btn btn-secondary mb-3 mt-3">Cancelar</a>
        </form>
    </div>
@endsection