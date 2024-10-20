<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.list', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.form');
    }

    public function edit($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado');
        }

        return view('produtos.form', [
            'produto' => $produto, 
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Produto::create($request->all());
        return redirect()->route('produtos.index')->with('success', 'Produto adicionado com sucesso!');
    }

    public function show($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado');
        }

        return view('produtos.form', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado');
        }

        $validator = Validator::make($request->all(), [
            'descricao' => 'sometimes|required|string|max:255',
            'preco' => 'sometimes|required|numeric|min:0',
            'estoque' => 'sometimes|required|integer|min:0',
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
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado');
        }
    
        if ($produto->vendas()->count() > 0) {
            return redirect()->route('produtos.index')->with('error', 'Não é possível remover este produto porque ele está associado a uma venda.');
        }
    
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso!');
    }    

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $produtos = Produto::where(
                $request->tipo,
                'like',
                "%$request->valor%"
            )->get();
        } else {
            $produtos = Produto::all();
        }

        return view('produtos.list', ['produtos' => $produtos]);
    }
}