<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    //

    public function users()
    {
        return $this
                ->hasMany(User::class, 'municipio_id');
    }
}
