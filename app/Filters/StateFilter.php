<?php

namespace App\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class StateFilter extends Filter
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
        return Product::query();
    }
}
