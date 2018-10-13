<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeIdentification extends Model
{
    //

    public function users()
    {
        return $this
                ->hasMany(User::class, 'type_identification_id');
    }
}
