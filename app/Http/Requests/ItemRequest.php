<?php

namespace App\Http\Requests;

use App\Enums\ItemCategory;
use App\Enums\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
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
            ['required', 'string', 'max:255', Rule::unique('items')->ignore($this->route('item'))],
            'category' =>['required', Rule::enum(ItemCategory::class)],
            'stock_quantity' => ['nullable','numeric', 'min:0'],
            'unit' => ['required', Rule::enum(Unit::class)],
        ];
    }
}
