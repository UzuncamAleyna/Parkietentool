<?php

namespace App;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
