<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeIdentification extends Model
{
    //

    public function user()
    {
        return $this
                ->belongsTo(User::class, 'type_identification_id');
    }
}
