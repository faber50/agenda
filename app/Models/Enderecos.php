<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'contato_id'
    ];

    protected $table = 'tb_enderecos';

    public function Contato()
    {
        return $this->belongsTo(Contatos::class,'id_user');
    }
}
