<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoUser extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_user';

    public function users()
    {
        return $this->hasMany(User::class, 'tipo_user_id');
    }
}
