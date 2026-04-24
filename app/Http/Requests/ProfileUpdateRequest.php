<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50', Rule::unique(User::class, 'nip')->ignore($this->user()->id)],
            'nis' => ['nullable', 'string', 'max:50', Rule::unique(User::class, 'nis')->ignore($this->user()->id)],
            'kelas' => ['nullable', 'string', 'max:50'],
        ];

        if ($this->user()?->role === 'admin') {
            $rules['nip'][0] = 'required';
        }

        if ($this->user()?->role === 'peminjam') {
            $rules['nis'][0] = 'required';
            $rules['kelas'][0] = 'required';
        }

        return $rules;
    }
}
