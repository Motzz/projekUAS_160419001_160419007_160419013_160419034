<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokAwal extends Model
{
    //
    protected $table = 'stock_awal';
    public $timestamps = false;

    public function medicine()
    {
        return $this->belongsTo('App\Medicines','medicines_id');
    }

    public function inventortTransaction()
    {
        return $this->hasMany('App\InventoryTransaction', 'stock_awal_id', 'id');
    }
}
