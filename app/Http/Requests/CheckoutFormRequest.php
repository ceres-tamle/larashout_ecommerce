<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'   => 'required|max:8|min:2',
            'last_name'    => 'required|max:8|min:2',
            'address'      => 'required|max:255',
            'city'         => 'required',
            'country'      => 'required',
            'post_code'    => 'required|numeric',
            'phone_number' => 'required|numeric',
            'email'        => 'required|email',
        ];
    }
}
