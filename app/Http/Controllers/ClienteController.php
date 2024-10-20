<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.list', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.form');
    }

    public function edit($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->with('error', 'Cliente não encontrado');
        }

        return view('clientes.form', compact('cliente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'nullable|in:masculino,feminino,outro',
            'cpf' => 'required|size:14|unique:clientes,cpf',
            'telefone' => 'nullable|max:20',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome pode ter no máximo 255 caracteres.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'Informe uma data válida.',
            'genero.in' => 'O gênero deve ser masculino, feminino ou outro.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter 14 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'telefone.max' => 'O telefone pode ter no máximo 20 caracteres.',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->with('error', 'Cliente não encontrado');
        }

        $request->validate([
            'nome' => 'required|max:100',
            'data_nascimento' => 'required|date',
            'genero' => 'nullable|in:masculino,feminino,outro',
            'cpf' => 'required|size:14|unique:clientes,cpf,' . $cliente->id,
            'telefone' => 'nullable|max:20',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome pode ter no máximo 100 caracteres.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'Informe uma data válida.',
            'genero.in' => 'O gênero deve ser masculino, feminino ou outro.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter 14 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'telefone.max' => 'O telefone pode ter no máximo 20 caracteres.',
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->with('error', 'Cliente não encontrado');
        }

        if ($cliente->vendas()->count() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', 'Não é possível remover este cliente porque ele está associado a uma venda.');
        }

        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $clientes = Cliente::where(
                $request->tipo,
                'like',
                "%$request->valor%"
            )->get();
        } else {
            $clientes = Cliente::all();
        }

        return view('clientes.list', ['clientes' => $clientes]);
    }
}