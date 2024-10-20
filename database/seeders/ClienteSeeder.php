<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('clientes')->insert([
            [
                'nome' => 'Eduardo Zang',
                'data_nascimento' => '2005-09-06',
                'genero' => 'masculino',
                'cpf' => '049.636.150-37',
                'telefone' => '(49) 2644-8453'
            ],
            [
                'nome' => 'Luis Tavares',
                'data_nascimento' => '2004-01-30',
                'genero' => 'masculino',
                'cpf' => '123.456.789-00',
                'telefone' => '(49) 9876-5432'
            ],
            [
                'nome' => 'Milena Zang',
                'data_nascimento' => '2007-04-27',
                'genero' => 'feminino',
                'cpf' => '987.654.321-00',
                'telefone' => '(49) 1234-5678'
            ],
        ]);
    }
}