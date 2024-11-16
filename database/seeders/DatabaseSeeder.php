<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ClienteSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(FuncionarioSeeder::class);
        $this->call(ProdutoSeeder::class);
        $this->call(VendaSeeder::class);
    }
}