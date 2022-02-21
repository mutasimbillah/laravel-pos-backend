<?php

namespace App\Filters;

use App\Models\State;

class StateFilter extends Filter {
    public function query($search) {
        $this->query->where('name', 'like', "%{$search}%");
    }

    /**
     * @inheritDoc
     */
    public function getQuery() {
        return State::query();
    }
}
