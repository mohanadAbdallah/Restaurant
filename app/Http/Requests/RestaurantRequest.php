<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'=>['required','string','max:255'],
            'phone'=>['required','string'],
            'address'=>['required','string'],
            'user_id'=>['required','numeric'],
            'image'=> ['nullable']
            ];
    }
}
