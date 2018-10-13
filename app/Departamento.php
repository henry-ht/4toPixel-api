<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    
    public function users()
    {
        return $this
                ->hasMany(User::class, 'departamento_id');
    }
}
