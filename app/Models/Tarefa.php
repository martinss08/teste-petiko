<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'status_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
