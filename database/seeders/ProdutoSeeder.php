<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('produtos')->insert([
            ['descricao' => 'Óculos de Sol', 'preco' => 199.99, 'estoque' => 10],
            ['descricao' => 'Lente de Contato', 'preco' => 89.99, 'estoque' => 50],
            ['descricao' => 'Estojo para óculos', 'preco' => 74.99, 'estoque' => 150],
        ]);
    }
}