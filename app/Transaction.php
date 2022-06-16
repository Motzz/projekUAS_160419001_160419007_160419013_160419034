<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    protected $table = 'transaction';

   /* public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function buyer()
    {
        return $this->belongsTo('App\Buyer','buyer_id');
    }

    public function medicines()
    {
        return $this->belongsToMany('App\Medicine')
                    ->withPivot('quantity','price');
    }*/
}
