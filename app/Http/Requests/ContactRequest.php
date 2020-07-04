<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            //
            'name' =>'required|max:15',
            'title' => 'required',
            'email' => 'required|email', 
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            //
            'required' => '必須項目です',
            'email' => 'メールアドレスの形式で入力してください',
            'name.max' => '15文字以下で入力してください',
        ];
    }
}
