<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'status_id',
        'data_tarefa',
        'user_id'
    ];

    protected $appends = ['atrasada'];

    public function getAtrasadaAttribute()
    {
        return $this->data_tarefa < now()->toDateString();
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
