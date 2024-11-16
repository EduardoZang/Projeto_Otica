<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = "funcionarios";

    protected $fillable = [
        'nome',
        'cargo',
        'foto_perfil', 
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'funcionario_id');
    }
}