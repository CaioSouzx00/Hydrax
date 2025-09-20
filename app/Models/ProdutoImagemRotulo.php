<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoImagemRotulo extends Model
{
    use HasFactory;

    protected $table = 'produto_imagem_rotulos';

    protected $fillable = [
        'id_produto',
        'imagem',
        'categoria',
        'estilo',
        'genero',
        'marca'
    ];

    public function produto()
    {
        return $this->belongsTo(ProdutoFornecedor::class, 'id_produto', 'id_produtos');
    }
}
