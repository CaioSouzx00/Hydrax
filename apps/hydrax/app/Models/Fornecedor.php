<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Fornecedor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'fornecedores';

    protected $primaryKey = 'id_fornecedores';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nome_empresa',
        'cnpj',
        'email',
        'telefone',
        'foto',
        'password',
        'status',
    ];

    protected $hidden = ['password'];

    public function setSenhaAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

public function produtos()
{
    return $this->hasMany(ProdutoFornecedor::class, 'id_fornecedores', 'id_fornecedores');
}


}