<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        Categoria::create([
            'nome' => 'Óculos de Sol',
            'descricao' => 'Óculos de sol para proteção e estilo.',
            'imagem' => 'categorias/oculos_sol.jpg',
        ]);

        Categoria::create([
            'nome' => 'Óculos de Grau',
            'descricao' => 'Óculos de grau para correção visual.',
            'imagem' => 'categorias/oculos_grau.jpg',
        ]);

        Categoria::create([
            'nome' => 'Óculos Esportivos',
            'descricao' => 'Óculos desenvolvidos para atividades esportivas.',
            'imagem' => 'categorias/oculos_esportivos.jpeg',
        ]);

        Categoria::create([
            'nome' => 'Óculos de Segurança',
            'descricao' => 'Óculos para proteção em ambientes de trabalho.',
            'imagem' => 'categorias/oculos_seguranca.jpg',
        ]);
    }
}