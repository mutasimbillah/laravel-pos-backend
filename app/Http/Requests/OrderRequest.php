<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [

            'customer_id'         => 'required|integer',
            'state_id'            => 'required|integer',
            'products.*.id'       => 'required|integer',
            'products.*.quantity' => 'required|integer',
        ];
    }
}
