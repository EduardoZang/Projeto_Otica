<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.list', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoria = new Categoria;
        $categoria->nome = $request->nome;
        $categoria->descricao = $request->descricao;

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('categorias', 'public');
            $categoria->imagem = $path;
        }

        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function edit($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Categoria não encontrada.');
        }

        return view('categorias.form', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoria = Categoria::find($id);
        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Categoria não encontrada.');
        }

        $categoria->nome = $request->nome;
        $categoria->descricao = $request->descricao;

        if ($request->has('imagem_excluir') && isset($categoria->imagem) && Storage::exists('public/' . $categoria->imagem)) {
            Storage::delete('public/' . $categoria->imagem);
            $categoria->imagem = null; 
        }

        if ($request->hasFile('imagem')) {
            if (isset($categoria->imagem) && Storage::exists('public/' . $categoria->imagem)) {
                Storage::delete('public/' . $categoria->imagem);
            }

            $path = $request->file('imagem')->store('categorias', 'public');
            $categoria->imagem = $path;
        }

        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
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
            return redirect()->route('categorias.index')->withErrors($validator)->withInput();
        }

        $query = Categoria::query();

        if (!empty($request->valor)) {
            if ($request->tipo === 'nome') {
                $query->where('nome', 'like', '%' . $request->valor . '%');
            } else {
                $query->where('descricao', 'like', '%' . $request->valor . '%');
            }
        }

        $categorias = $query->get();

        return view('categorias.list', compact('categorias'));
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Categoria não encontrada.');
        }

         if ($categoria->produtos()->count() > 0) {
             return redirect()->route('categorias.index')->with('error', 'Não é possível remover esta categoria porque ela está associada a um produto.');
         }

        if (isset($categoria->imagem) && Storage::exists('public/' . $categoria->imagem)) {
            Storage::delete('public/' . $categoria->imagem);
        }

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
    }
}