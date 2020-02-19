<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Indicamos la tabla de nuestra base de datos que vamos a usar en el modelo
    //protected $table = 'posts';
    public $timestamps = false;
        protected $fillable = [
        'title','content','category_id', 'image',
    ];
        
        protected $fileRules = [
        'File', 'Image', 'Mimes', 'Mimetypes', 'Min',
        'Max', 'Size', 'Between', 'Dimensions',
    ];

    //Relacionamos en este caso de muchos a uno en ambas relaciones de la tabla (belongsTo)
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }
            
}
