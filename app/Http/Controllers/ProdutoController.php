<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with(['cliente', 'categoria'])->get();
        return view('produtos.list', compact('produtos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $categorias = Categoria::all();
        return view('produtos.form', compact('clientes', 'categorias'));
    }

    public function edit($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado.');
        }

        $clientes = Cliente::all();
        $categorias = Categoria::all();

        return view('produtos.form', compact('produto', 'clientes', 'categorias'));
    }

    public function gerarRelatorio()
    {
        $produtos = Produto::with(['cliente', 'categoria'])->get();
        $pdf = Pdf::loadView('produtos.relatorio', compact('produtos'));

        return $pdf->download('relatorio_produtos.pdf');
    }

    public function show()
    {
        $produtos = Produto::with(['cliente', 'categoria'])->get();

        return view('produtos.relatorio', compact('produtos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'cliente_id' => 'required|exists:clientes,id',
            'categoria_id' => 'required|exists:categorias,id',
        ], [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição não pode exceder 255 caracteres.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'preco.min' => 'O preço deve ser maior ou igual a 0.',
            'estoque.required' => 'O estoque é obrigatório.',
            'estoque.integer' => 'O estoque deve ser um número inteiro.',
            'estoque.min' => 'O estoque não pode ser negativo.',
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Produto::create($request->all());
        return redirect()->route('produtos.index')->with('success', 'Produto adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado.');
        }

        $validator = Validator::make($request->all(), [
            'descricao' => 'sometimes|required|string|max:255',
            'preco' => 'sometimes|required|numeric|min:0',
            'estoque' => 'sometimes|required|integer|min:0',
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'categoria_id' => 'sometimes|required|exists:categorias,id',
        ], [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição não pode exceder 255 caracteres.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'preco.min' => 'O preço deve ser maior ou igual a 0.',
            'estoque.required' => 'O estoque é obrigatório.',
            'estoque.integer' => 'O estoque deve ser um número inteiro.',
            'estoque.min' => 'O estoque não pode ser negativo.',
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $produto->update($request->all());
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado.');
        }

        if ($produto->vendas()->count() > 0) {
            return redirect()->route('produtos.index')->with('error', 'Não é possível remover este produto porque ele está associado a uma venda.');
        }

        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso!');
    }
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|in:descricao,preco,estoque,cliente',
            'valor' => 'nullable|string|max:255',
        ], [
            'tipo.required' => 'O tipo de busca é obrigatório.',
            'tipo.string' => 'O tipo de busca deve ser um texto.',
            'tipo.in' => 'O tipo de busca selecionado é inválido.',
            'valor.string' => 'O valor da busca deve ser um texto.',
            'valor.max' => 'O valor da busca não pode exceder 255 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('produtos.index')->withErrors($validator)->withInput();
        }

        $query = Produto::query();

        if (!empty($request->valor)) {
            if ($request->tipo === 'cliente') {
                $query->whereHas('cliente', function ($q) use ($request) {
                    $q->where('nome', 'like', '%' . $request->valor . '%');
                });
            } else {
                $query->where($request->tipo, 'like', '%' . $request->valor . '%');
            }
        }

        $produtos = $query->get();

        return view('produtos.list', compact('produtos'));
    }
}