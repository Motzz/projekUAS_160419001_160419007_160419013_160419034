<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustmentStok extends Model
{
    //
    protected $table = 'adjustment_stock';
    public $timestamps = false;

    public function medicine()
    {
        return $this->belongsTo('App\Medicines','medicines_id');
    }

    public function inventortTransaction()
    {
        return $this->hasMany('App\InventoryTransaction', 'adjustment_stock_id', 'id');
    }
}
