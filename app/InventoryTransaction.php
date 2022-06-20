<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    //
    protected $table = 'inventory_transaction';
    public $timestamps = false;

    public function medicines()
    {
        return $this->belongsToMany('App\Medicines', 'inventory_transactionline', 'inventory_transaction_id	', 'medicines_id')
        ->withPivot('id', 'jumlah');
    }
}
