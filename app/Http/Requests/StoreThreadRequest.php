<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreThreadRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:8', 'max:255'],
            'body' => ['required', 'string', 'min:10', 'max:20000'],
            'tags' => ['nullable', 'string', 'max:200'],
            'tag_names' => ['array', 'max:'.Tag::MAX_PER_THREAD],
            'tag_names.*' => ['string', 'regex:'.Tag::NAME_PATTERN],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tag_names.max' => 'Use at most :max tags.',
            'tag_names.*.regex' => 'Tags can only use lowercase letters, numbers and . + # - (max 30 characters).',
        ];
    }

    /**
     * Parse the free-form tags field into normalized names. The raw input
     * stays in `tags` so the form can redisplay exactly what was typed.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['tag_names' => Tag::parse($this->input('tags'))]);
    }

    /**
     * @return array{title: string, body: string}
     */
    public function threadAttributes(): array
    {
        return $this->safe()->only(['title', 'body']);
    }
}
