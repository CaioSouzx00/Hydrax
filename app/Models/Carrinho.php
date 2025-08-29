<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    use HasFactory;

    protected $fillable = ['id_usuarios', 'status'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuarios');
    }

    public function itens()
    {
        return $this->hasMany(CarrinhoItem::class, 'carrinho_id');
    }
}

