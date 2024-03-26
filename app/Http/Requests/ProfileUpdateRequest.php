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
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'employee_id' => ['required', 'integer', 'max:10'],
            'first_name'=> ['required', 'string', 'max:20'],
            'last_name'=> ['required', 'string', 'max:20'],
            'phone'=> ['required', 'string', 'max:20'],
            'joining_date'=> ['required', 'string'],
            'dob'=> ['required', 'string'],
            'address'=> ['required', 'string', 'max:255'],
            'about'=> ['required', 'string', 'max:500'],
            'position'=> ['required', 'string', 'max:20'],
            'passport'=> ['required', 'string', 'max:20'],
            'nid'=> ['required', 'string', 'max:20'],
            'device_token' => ['required', 'string', 'max:1000'],
        ];
    }
}
