<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoEstoque extends Model
{
    use HasFactory;

    protected $table = 'produto_estoques';

    protected $fillable = [
        'produto_id',
        'tamanho',
        'quantidade',
    ];

    public function produto()
    {
        return $this->belongsTo(ProdutoFornecedor::class, 'produto_id', 'id_produtos');
    }
}
