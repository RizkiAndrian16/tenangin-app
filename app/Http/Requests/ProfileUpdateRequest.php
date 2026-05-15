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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'gender' => [
                'nullable',
                'in:Laki-laki,Perempuan'
            ],

            'age' => [
                'nullable',
                'integer',
                'min:1',
                'max:100'
            ],

            'phone_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s]+$/'
            ],

            'university' => [
                'nullable',
                'string',
                'max:255'
            ],

            'major' => [
                'nullable',
                'string',
                'max:255'
            ],

            'semester' => [
                'nullable',
                'integer',
                'min:1',
                'max:14'
            ],

            'residence_status' => [
                'nullable',
                'in:Rumah Orang Tua,Kos,Asrama,Kontrakan,Lainnya'
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ];
    }
}
