<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustmentStok extends Model
{
    //

    public function medicine()
    {
        return $this->belongsTo('App\Medicines','medicines_id');
    }
}
