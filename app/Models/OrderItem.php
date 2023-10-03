<?php

namespace App\Models;

use App\Order;
use App\Ring;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'orders_items'; //Om de naam van de tussentabel te veranderen van orders_rings naar orders_items
    protected $fillable = ['order_id', 'ring_id']; 
    public $timestamps = false; //Om de created_at en updated_at timestamps niet te gebruiken

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ring()
    {
        return $this->belongsTo(Ring::class);
    }
}
