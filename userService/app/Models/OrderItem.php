<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    protected $table = 'order_items';

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];
}