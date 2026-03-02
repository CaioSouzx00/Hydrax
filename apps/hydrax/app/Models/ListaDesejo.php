<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProdutoFornecedor; // <- Certifique que o import existe

class ListaDesejo extends Model
{
    use HasFactory;

    protected $table = 'lista_desejos';
    protected $primaryKey = 'id_lista';
    protected $fillable = ['id_usuarios', 'id_produtos'];

    public function produto()
    {
        return $this->belongsTo(ProdutoFornecedor::class, 'id_produtos', 'id_produtos'); 
        // <- aqui não pode ter "ProdutosFornecedores"
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuarios', 'id_usuarios');
    }
}

