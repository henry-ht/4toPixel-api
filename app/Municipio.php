<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    //

    public function user()
    {
        return $this
                ->belongsTo(User::class, 'municipio_id');
    }
}
