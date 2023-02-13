<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConrtactRequest extends FormRequest


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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'name_kana' => ['nullable','string'],
            'email' => ['confirmed','required','email'],
            'email_confirmation' => ['required','email'],
            'phone' => ['nullable','string','digits_between:10,11','numeric'],
            'content' => ['required'],
        ];
    }

   
    

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return ['name.required' => '氏名は必須入力です',
                'email.required' => 'メールアドレスは必須入力です',
                'email_confirmation.required' => 'メールアドレス確認は必須入力です',
                'content.required' => 'お問合せ内容は必須入力です',
                
        ];
    }
}