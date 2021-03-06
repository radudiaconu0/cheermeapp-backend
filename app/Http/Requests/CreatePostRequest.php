<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'text'=>'required|string'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
