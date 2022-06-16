<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicines extends Model
{
    protected $table = 'medicines';
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function transactions() 
    {
        return $this->belongsToMany('App\transaction') 
                    ->withPivot('id', 'quantity','price', 'totalPrice');
    }
}
