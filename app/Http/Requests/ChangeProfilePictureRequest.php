<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeProfilePictureRequest extends FormRequest
{
    public function rules()
    {
        return [
            'profile_pic' => ['required','file','max:30000', 'mimes:jpg,png']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
