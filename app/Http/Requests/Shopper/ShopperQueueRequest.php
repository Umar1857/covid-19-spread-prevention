<?php

namespace App\Http\Requests\Shopper;

use Illuminate\Foundation\Http\FormRequest;

class ShopperQueueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
        ];
    }
}
