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
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'interests' => ['nullable', 'string', 'max:500'],
            'favorite_topics' => ['nullable', 'string', 'max:500'],
            'preferred_book_categories' => ['nullable', 'string', 'max:500'],
            'skills' => ['nullable', 'string', 'max:500'],
            'educational_interests' => ['nullable', 'string', 'max:500'],
            'learning_goals' => ['nullable', 'string', 'max:500'],
        ];
    }
}