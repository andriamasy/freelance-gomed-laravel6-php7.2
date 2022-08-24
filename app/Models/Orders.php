<?php
/*
  Authors : Sayna (Rahul Jograna)
  Website : https://sayna.io/
  App Name : Grocery Delivery App
  This App Template Source code is licensed as per the
  terms found in the Website https://sayna.io/license
  Copyright and Good Faith Purchasers © 2021-present Sayna.
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    public $timestamps = true; //by default timestamp false

    protected $fillable = ['uid','store_id','date_time','paid_method','order_to','orders','notes','address',
    'driver_id','assignee','total','tax','grand_total','discount','delivery_charge','wallet_used','wallet_price',
    'extra','pay_key','coupon_code','status','payStatus','extra_field'];

    protected $hidden = [
        'updated_at', 'created_at',
    ];

    protected $casts = [
        'wallet_used' => 'integer',
        'payStatus' => 'integer'
    ];
}
