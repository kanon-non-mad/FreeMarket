<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_name' => ['required','string'],
            'description' => ['required','string','max:255'],
            'item_image' => ['required','file','image','mimes:jpeg,png'],
            'category_id' => ['required','array'],
            'category_id.*' => ['exists:categories,id'],
            'condition' => ['required','integer'],
            'price' =>['required','numeric','min:0'],
            'brand' => ['nullable', 'string', 'max:255'],
        ];
    }
}
