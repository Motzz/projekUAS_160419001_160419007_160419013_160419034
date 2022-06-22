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

    public function transaction()
    {
        return $this->belongsTo('App\Transaction','transaction_id');
    }

    public function stokAwal()
    {
        return $this->belongsTo('App\StokAwal','stock_awal_id');
    }

    public function adjustmentStok()
    {
        return $this->belongsTo('App\AdjustmentStok','adjustment_stock_id');
    }
}
