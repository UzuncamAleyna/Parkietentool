<?php

namespace App;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;


class Ring extends Model
{
    public function orders()
    {
        return $this->hasMany(OrderItem::class, 'ring_id'); //ring_id is de foreign key
    }
}
