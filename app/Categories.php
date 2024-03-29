<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    public function medicine()
    {
        return $this->hasMany('App\Medicine', 'category_id', 'id');
    }

}
