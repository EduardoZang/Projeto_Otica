<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Relatório de Produtos</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Comissão</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>{{ $produto->descricao }}</td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td>{{ $produto->estoque }}</td>
                    <td>{{ $produto->cliente->nome }}</td>
                    <td>{{ $produto->categoria->nome ?? 'Sem categoria' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>