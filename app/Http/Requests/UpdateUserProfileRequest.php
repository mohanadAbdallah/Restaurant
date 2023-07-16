<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserProfileRequest extends FormRequest
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
        $userId = auth()->user()->id;
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email,'.$userId],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['nullable','string','min:8','confirmed'],
            'image' => ['nullable','file'],
        ];
    }
}
