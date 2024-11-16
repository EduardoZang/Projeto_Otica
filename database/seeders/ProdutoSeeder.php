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
            ['descricao' => 'Ray-Ban Óculos de Sol Masculino', 'preco' => 199.99, 'estoque' => 10, 'cliente_id' => 1, 'categoria_id'=> 1],
            ['descricao' => 'Óculos de grau Vogue - Rosa', 'preco' => 799.99, 'estoque' => 30, 'cliente_id' => 2,'categoria_id'=> 2],
            ['descricao' => 'Óculos esportivo Oakley - Ciclismo', 'preco' => 359.99, 'estoque' => 150, 'cliente_id' => 3, 'categoria_id'=> 3],
        ]);
    }
}