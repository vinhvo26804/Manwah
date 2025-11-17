<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['table_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class);
    }
}
