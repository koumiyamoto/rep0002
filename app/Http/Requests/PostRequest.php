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
            'title' => 'required|min:3|max:120',
            'body' => 'required',
            'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages() {
        return [
            'title.required' => '※必須項目です',
            'title.min' => '※タイトルは3文字以上120文字以下で入力してください',
            'title.max' => '※タイトルは3文字以上60文字以下で入力してください',
            'body.required' => '※必須項目です',
            'image' => '※画像ファイルの形式が正しくありません',
        ];

    }
}
