@extends('base')
@section('titulo', isset($funcionario) ? 'Editar Funcionário' : 'Adicionar Funcionário')
@section('conteudo')

<div class="container">
    <h1>{{ isset($funcionario) ? 'Editar Funcionário' : 'Adicionar Funcionário' }}</h1>
    <form action="{{ isset($funcionario) ? route('funcionarios.update', $funcionario->id) : route('funcionarios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($funcionario))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nome">Nome do Funcionário</label>
            <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', isset($funcionario) ? $funcionario->nome : '') }}" required>
        </div>

        <div class="form-group">
            <label for="cargo">Cargo</label>
            <input type="text" class="form-control" name="cargo" id="cargo" value="{{ old('cargo', isset($funcionario) ? $funcionario->cargo : '') }}" required>
        </div>

        @if (isset($funcionario) && $funcionario->foto_perfil)
            <div class="form-group">
                <label for="foto_perfil">Foto de Perfil Atual</label><br>
                <img src="{{ asset('storage/' . $funcionario->foto_perfil) }}" alt="$funcionario->nome" style="max-width: 200px; max-height: 200px;">
                <br>
            </div>
        @endif

        <div class="form-group">
            <label for="foto_perfil">Nova Foto de Perfil</label>
            <input type="file" class="form-control" name="foto_perfil" id="foto_perfil">
        </div>

        <button type="submit" class="btn btn-success mb-3 mt-3">{{ isset($funcionario) ? 'Atualizar' : 'Adicionar' }}</button>
        <a href="{{ route('funcionarios.index') }}" class="btn btn-secondary mb-3 mt-3">Cancelar</a>
    </form>
</div>

@endsection