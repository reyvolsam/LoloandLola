<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model{

    public function service()
    {
        return $this->belongsTo('App\Service');
    }//region()
}
