<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Vendas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Relatório de Vendas</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Funcionário</th>
                <th>Quantidade</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>