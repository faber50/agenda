<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    use HasFactory;

    protected $fillable = [
        'imagem',
        'nome',
        'email',
        'telefone',
        'celular',
        'favorito'
    ];

    protected $table = 'tb_contatos';

    public function Enderecos()
    {
        return $this->hasMany(Enderecos::class,'contato_id', 'id');
        
    }
}
