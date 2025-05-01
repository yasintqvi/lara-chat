<?php

namespace App\Http\Requests;

class GroupRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'members' => ['nullable', 'array'],
            'members.*' => ['nullable', 'exists:users,id'],
        ];
    }
}
