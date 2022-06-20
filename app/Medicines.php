<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categories;
class Medicines extends Model
{
    protected $table = 'medicines';
        public $timestamps = false;
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function transactions()
    {
        return $this->belongsToMany('App\Transaction', 'medicine_transaction', 'medicines_id', 'transaction_id')
        ->withPivot('id', 'quantity', 'price', 'totalprice');
    }

    public function inventoryTransaction()
    {
        return $this->belongsToMany('App\InventoryTransaction', 'inventory_transactionline', 'medicines_id', 'inventory_transaction_id')
        ->withPivot('id', 'jumlah');
    }

    public function stokAwals()
    {
        return $this->hasMany('App\StokAwal', 'medicines_id', 'id');
    }

    public function adjustment()
    {
        return $this->hasMany('App\AdjustmentStok', 'medicines_id', 'id');
    }
    
}
