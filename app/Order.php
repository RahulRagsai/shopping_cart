<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'order_item_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
