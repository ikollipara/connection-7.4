<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCollectionRequest extends FormRequest
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
     * @return array<string, string|array<string>>
     */
    public function rules()
    {
        return [
            "title" => "required_if:published,true",
            "published" => "required|boolean",
            "body" => "required_if:published,true|json",
            "user_id" => "required|exists:users,id",
            "metadata" => "required_if:published,true|json",
        ];
    }
}
