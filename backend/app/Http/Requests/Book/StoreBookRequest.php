<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Traits\ResponseTrait;
class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string|max:255",
            "author" => "required|string|max:255",
            "publisher" => "nullable|string|max:255",
            "published_year" => "nullable|digits:4|integer|min:1000|max:" . now()->year,
            "description" => "nullable|string",
            "price" => "required|numeric|min:0",
            "stock" => "nullable|integer|min:0",
            "image" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
            "sold" => "nullable|integer|min:0",
            "is_available" => "nullable|boolean",
            "rating" => "nullable|integer|min:1|max:5"
        ];
    }
    //  protected function failedValidation(Validator $validator)
    // {
    //     $errors = (new ValidationException($validator))->errors();
    //     throw new HttpResponseException(ResponseTrait::fail($errors, "error", 422));

    // }
}
