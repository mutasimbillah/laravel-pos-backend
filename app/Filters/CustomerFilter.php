<?php

namespace App\Filters;

use App\Models\Customer;

class CustomerFilter extends Filter
{
    public function query($search)
    {
        $this->query->where('name', 'like', "%{$search}%");
    }

    /**
     * @inheritDoc
     */
    public function getQuery()
    {
        return Customer::query();
    }
}
