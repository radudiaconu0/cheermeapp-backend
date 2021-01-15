<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdatePostRequest extends FormRequest
{
    #[ArrayShape(['text' => "string"])] public function rules(): array
    {
        return [
            'text' => 'required|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
