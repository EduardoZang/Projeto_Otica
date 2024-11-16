<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funcionario;

class FuncionarioSeeder extends Seeder
{
    public function run()
    {
        Funcionario::create([
            'nome' => 'Júlio César dos Santos',
            'cargo' => 'Vendedor',
            'foto_perfil' => 'funcionarios/julio_cesar.jpg',
        ]);

        Funcionario::create([
            'nome' => 'Teresinha Juliana Teresinha Assis',
            'cargo' => 'Gerente de vendas',
            'foto_perfil' => 'funcionarios/teresinha_assis.jpg',
        ]);

        Funcionario::create([
            'nome' => 'Lara Sandra Caroline Figueiredo',
            'cargo' => 'Médica Oftalmologista',
            'foto_perfil' => 'funcionarios/lara_figueiredo.jpg',
        ]);
    }
}