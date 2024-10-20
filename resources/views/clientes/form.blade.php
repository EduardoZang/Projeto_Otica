@extends('base')
@section('titulo', isset($cliente) ? 'Editar Cliente' : 'Adicionar Cliente')

@section('conteudo')
    <div class="container">
        <h1>{{ isset($cliente) ? 'Editar Cliente' : 'Adicionar Cliente' }}</h1>
        <form action="{{ isset($cliente) ? route('clientes.update', $cliente->id) : route('clientes.store') }}" method="POST">
            @csrf
            @if (isset($cliente))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', isset($cliente) ? $cliente->nome : '') }}" required>
            </div>

            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento', isset($cliente) ? $cliente->data_nascimento : '') }}" required>
            </div>

            <div class="form-group">
                <label for="genero">Gênero</label>
                <select class="form-control" name="genero" id="genero">
                    <option value="" disabled {{ !isset($cliente) ? 'selected' : '' }}>Selecione</option>
                    <option value="masculino" {{ old('genero', isset($cliente) ? $cliente->genero : '') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="feminino" {{ old('genero', isset($cliente) ? $cliente->genero : '') == 'feminino' ? 'selected' : '' }}>Feminino</option>
                    <option value="outro" {{ old('genero', isset($cliente) ? $cliente->genero : '') == 'outro' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" id="cpf" value="{{ old('cpf', isset($cliente) ? $cliente->cpf : '') }}" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="telefone" value="{{ old('telefone', isset($cliente) ? $cliente->telefone : '') }}">
            </div>

            <button type="submit" class="btn btn-success mb-3 mt-3">{{ isset($cliente) ? 'Atualizar' : 'Adicionar' }}</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary mb-3 mt-3">Cancelar</a>
        </form>
    </div>
@endsection