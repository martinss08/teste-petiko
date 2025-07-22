<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'status_id');
    }
}