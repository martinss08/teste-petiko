<?php

namespace App\Models;

use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
    
    protected $table = 'status';

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'status_id');
    }
}