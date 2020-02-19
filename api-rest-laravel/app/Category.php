<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Indicamos la tabla de nuestra base de datos que vamos a usar en el modelo
    protected  $table = 'categories';

    //Relacionamos en este caso de uno a muchos (hasMany)
    public function posts(){
        return $this->hasMany('App\Post');
    }
}
