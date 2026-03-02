<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingEmailChange extends Model
{
    protected $fillable = ['usuario_id', 'novo_email', 'token'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
