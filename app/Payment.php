<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model{

    public function discount()
    {
        return $this->belongsTo('App\Discount');
    }//region()

    public function payment_type()
    {
        return $this->belongsTo('App\PaymentType');
    }//region()

    public function service_payment()
    {
        return $this->hasMany('App\ServicePayment', 'payment_id');
    }

    public function product_payment()
    {
        return $this->hasMany('App\ProductPayment', 'payment_id');
    }
}////
