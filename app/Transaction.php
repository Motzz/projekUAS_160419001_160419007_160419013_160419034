<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    protected $table = 'transaction';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function medicines()
    {
        return $this->belongsToMany('App\Medicines', 'medicine_transaction', 'transaction_id', 'medicines_id')
        ->withPivot('id', 'quantity', 'price', 'totalprice');
    }

}
