<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('vendas')->insert([
            [
                'cliente_id' => 1, // ID do cliente Eduardo Zang
                'produto_id' => 1,  // ID do produto Óculos de Sol
                'quantidade' => 2,
            ],
            [
                'cliente_id' => 2, // ID do cliente Luis Tavares
                'produto_id' => 2,  // ID do produto Lente de Contato
                'quantidade' => 5,
            ],
            [
                'cliente_id' => 3, // ID do cliente Milena Zang
                'produto_id' => 3,  // ID do produto Estojo para óculos
                'quantidade' => 1,
            ],
        ]);
    }
}