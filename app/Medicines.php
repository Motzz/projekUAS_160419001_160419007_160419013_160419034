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

    public function transactionQuantity()
    {
        return $this->belongsToMany('App\Transaction', 'medicine_transaction', 'medicines_id', 'transaction_id',)
            ->selectRaw('sum(quantity) as totalQuantity')
            ->groupBy('medicines_id');
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
