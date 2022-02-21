<?php

namespace App\Filters;

use App\Models\Order;

class OrderFilter extends Filter {
    public function query($search) {
        $this->query->where('name', 'like', "%{$search}%");
    }

    /**
     * @inheritDoc
     */
    public function getQuery() {
        return Order::query();
    }
}
