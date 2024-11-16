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
        'cliente_id',
        'categoria_id',
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'produto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}