<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreComment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => 'required|integer|exists:blog_posts,id',
            'message' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.integer' => 'Must be integer',
            'post_id.required' => 'Post id is required',
            'message.required' => 'Message is required'
        ];
    }
}
