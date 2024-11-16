@extends('base')
@section('titulo', 'Listagem de Funcionários')
@section('conteudo')

<div class="container">
    <h1>Funcionários</h1>
    <a href="{{ url('funcionarios/create') }}" class="btn btn-primary mb-3">Adicionar Funcionário</a>

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
        <form action="{{ route('funcionarios.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-3">
                    <select name="tipo" class="form-select">
                        <option value="nome">Nome</option>
                        <option value="cargo">Cargo</option>
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

    @if($funcionarios->isEmpty())
        <div class="alert alert-info">Não há nenhum funcionário cadastrado.</div>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Foto de Pefil</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($funcionarios as $funcionario)
                    <tr>
                        <td>{{ $funcionario->id }}</td>
                        <td>{{ $funcionario->nome }}</td>
                        <td>{{ $funcionario->cargo }}</td>
                        <td>
                            @if($funcionario->foto_perfil)
                                <img src="{{ Storage::url($funcionario->foto_perfil) }}" alt="{{ $funcionario->nome }}" width="100">
                            @else
                                <span>Sem foto de perfil</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-warning">Editar</a>

                            <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="post" style="display:inline;">
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