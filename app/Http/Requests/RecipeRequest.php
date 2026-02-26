<?php

namespace App\Http\Requests;

use App\Enums\RecipeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::enum(RecipeType::class)],
            'portions' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:0',
        ];
    }
}
