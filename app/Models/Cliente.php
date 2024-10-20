<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = "clientes";

    protected $fillable = [
        'nome',
        'data_nascimento',
        'genero',
        'cpf',
        'telefone',
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'produto_id');
    }
}