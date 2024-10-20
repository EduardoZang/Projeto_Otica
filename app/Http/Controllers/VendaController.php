<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with(['cliente', 'produto'])->get();
        return view('vendas.list', compact('vendas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('vendas.form', compact('clientes', 'produtos'));
    }

    public function edit($id)
    {
        $venda = Venda::find($id);

        if (!$venda) {
            return redirect()->route('vendas.index')->with('error', 'Venda não encontrada');
        }

        $clientes = Cliente::all();
        $produtos = Produto::all();

        return view('vendas.form', compact('venda', 'clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ], [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'produto_id.required' => 'O produto é obrigatório.',
            'produto_id.exists' => 'O produto selecionado não existe.',
            'quantidade.required' => 'A quantidade é obrigatória.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade deve ser maior ou igual a 1.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Venda::create($request->all());
        return redirect()->route('vendas.index')->with('success', 'Venda adicionada com sucesso!');
    }

    public function show($id)
    {
        $venda = Venda::with(['cliente', 'produto'])->find($id);

        if (!$venda) {
            return redirect()->route('vendas.index')->with('error', 'Venda não encontrada');
        }

        return view('vendas.form', compact('venda'));
    }

    public function update(Request $request, $id)
    {
        $venda = Venda::find($id);

        if (!$venda) {
            return redirect()->route('vendas.index')->with('error', 'Venda não encontrada');
        }

        $validator = Validator::make($request->all(), [
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'produto_id' => 'sometimes|required|exists:produtos,id',
            'quantidade' => 'sometimes|required|integer|min:1',
        ], [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'produto_id.required' => 'O produto é obrigatório.',
            'produto_id.exists' => 'O produto selecionado não existe.',
            'quantidade.required' => 'A quantidade é obrigatória.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade deve ser maior ou igual a 1.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $venda->update($request->all());
        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $venda = Venda::find($id);

        if (!$venda) {
            return redirect()->route('vendas.index')->with('error', 'Venda não encontrada');
        }

        $venda->delete();
        return redirect()->route('vendas.index')->with('success', 'Venda removida com sucesso!');
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|in:cliente,produto,quantidade',
            'valor' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vendas.index')->withErrors($validator)->withInput();
        }

        $query = Venda::with(['cliente', 'produto']);

        if (!empty($request->valor)) {
            if ($request->tipo === 'cliente') {
                $query->whereHas('cliente', function($q) use ($request) {
                    $q->where('nome', 'like', '%' . $request->valor . '%');
                });
            } elseif ($request->tipo === 'produto') {
                $query->whereHas('produto', function($q) use ($request) {
                    $q->where('descricao', 'like', '%' . $request->valor . '%');
                });
            } elseif ($request->tipo === 'quantidade') {
                $query->where('quantidade', 'like', '%' . $request->valor . '%');
            }
        }

        $vendas = $query->get();

        return view('vendas.list', compact('vendas'));
    }
}