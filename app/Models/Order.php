<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    protected function getTotalAttribute()
    {
        return $this->orderItems->sum(function (OrderItem $item) {
            return $item->price * $item->quantity;
        });
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
