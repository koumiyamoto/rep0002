<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //認証なしならば、true
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
            'title' => 'required|min:3|max:120',
            'body' => 'required',
            'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '※タイトルは入力必須項目です。',
            'title.min' => '※タイトルは3文字以上で入力してください',
            'title.max' => '※タイトルは120文字以下で入力してください',
            'body.required' => '※本文は入力必須項目です',
            'image' => '※画像ファイルの形式が正しくありません',
        ];

    }
}
