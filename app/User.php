<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function departamento()
    {
        return $this
                ->hasOne(Departamento::class, 'id', 'departamento_id');
    }

    public function municipio()
    {
        return $this
                ->hasOne(Municipio::class, 'id', 'municipio_id');
    }

    public function typeIdentification()
    {
        return $this
                ->hasOne(TypeIdentification::class, 'id', 'type_identification_id');
    }
}
