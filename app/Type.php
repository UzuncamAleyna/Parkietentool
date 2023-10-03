<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Type extends Model
{
    // relatie tussen rings and types
    public function rings()
{
    return $this->hasMany(Ring::class);
}
}
