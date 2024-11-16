<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use Illuminate\Support\Facades\Storage;
use Validator;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::all();
        return view('funcionarios.list', compact('funcionarios'));
    }

    public function create()
    {
        return view('funcionarios.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $funcionario = new Funcionario;
        $funcionario->nome = $request->nome;
        $funcionario->cargo = $request->cargo;

        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('funcionarios', 'public');
            $funcionario->foto_perfil = $path;
        }

        $funcionario->save();

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
        }

        return view('funcionarios.form', compact('funcionario'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $funcionario = Funcionario::find($id);
        if (!$funcionario) {
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
        }

        $funcionario->nome = $request->nome;
        $funcionario->cargo = $request->cargo;

        if ($request->has('foto_perfil_excluir') && isset($funcionario->foto_perfil) && Storage::exists('public/' . $funcionario->foto_perfil)) {
            Storage::delete('public/' . $funcionario->foto_perfil);
            $funcionario->foto_perfil = null; 
        }

        if ($request->hasFile('foto_perfil')) {
            if (isset($funcionario->foto_perfil) && Storage::exists('public/' . $funcionario->foto_perfil)) {
                Storage::delete('public/' . $funcionario->foto_perfil);
            }

            $path = $request->file('foto_perfil')->store('funcionarios', 'public');
            $funcionario->foto_perfil = $path;
        }

        $funcionario->save();

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|string|in:nome,descricao',
            'valor' => 'nullable|string|max:255',
        ], [
            'tipo.required' => 'O tipo de busca é obrigatório.',
            'tipo.string' => 'O tipo de busca deve ser um texto.',
            'tipo.in' => 'O tipo de busca selecionado é inválido.',
            'valor.string' => 'O valor da busca deve ser um texto.',
            'valor.max' => 'O valor da busca não pode exceder 255 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('funcionarios.index')->withErrors($validator)->withInput();
        }

        $query = Funcionario::query();

        if (!empty($request->valor)) {
            if ($request->tipo === 'nome') {
                $query->where('nome', 'like', '%' . $request->valor . '%');
            } else {
                $query->where('cargo', 'like', '%' . $request->valor . '%');
            }
        }

        $funcionarios = $query->get();

        return view('funcionarios.list', compact('funcionarios'));
    }

    public function destroy($id)
    {
        $funcionario = Funcionario::find($id);
        if (!$funcionario) {
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
        }

         if ($funcionario->vendas()->count() > 0) {
             return redirect()->route('funcionarios.index')->with('error', 'Não é possível remover este funcionário porque ele está associado a uma venda.');
         }

        if (isset($funcionario->foto_perfil) && Storage::exists('public/' . $funcionario->foto_perfil)) {
            Storage::delete('public/' . $funcionario->foto_perfil);
        }

        $funcionario->delete();

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso!');
    }
}