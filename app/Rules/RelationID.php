<?php

namespace App\Rules;

use App\Models\State;
use Illuminate\Contracts\Validation\Rule;

class RelationID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {

        return State::find($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Relation ID is invalid';
    }
}
