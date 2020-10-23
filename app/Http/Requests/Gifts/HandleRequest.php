<?php

namespace App\Http\Requests\Gifts;

use Illuminate\Foundation\Http\FormRequest;

class HandleRequest extends FormRequest
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
            'type'  => 'nullable|string',
            'pin'   => 'nullable|string|min:1|max:255',
            'email' => 'nullable|email|min:4|max:255'
        ];
    }
}
