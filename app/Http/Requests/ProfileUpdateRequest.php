<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'nama' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],

            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'NIP' => ['required', 'integer', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_tlp' => ['required', 'string', 'max:255'],
        ];
    }
}