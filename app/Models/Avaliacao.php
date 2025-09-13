<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';
    protected $primaryKey = 'id_avaliacoes';

    protected $fillable = [
        'id_usuarios',
        'id_produtos',
        'nota',
        'comentario',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuarios', 'id_usuarios');
    }

    public function produto()
    {
        return $this->belongsTo(ProdutoFornecedor::class, 'id_produtos', 'id_produtos');
    }
}
