<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = "produtos";

    protected $fillable = [
        'descricao',
        'preco',
        'estoque',
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'produto_id');
    }
}
