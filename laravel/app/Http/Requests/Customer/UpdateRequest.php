<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
        'email' => 'required|email|unique:users,email,'.Auth::user()->email.',email',
        'name' => 'required|max:100',
        'zipcode' => 'nullable|integer|max:9999999',
        'pref_code' => 'nullable|integer|max:47',
        'city' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:255',
        'building' => 'nullable|string|max:150',
        'url' => 'nullable|max:100',
        'thumb' => 'nullable|image:jpg、png、gif',
        'file_name' => 'nullable||max:100',
        'greeting' => 'nullable|max:140',
      ];
    }

    public function attributes()
    {
      return [
        'email' => 'メールアドレス',
        'name' => '事務所名',
        'zipcode' => '郵便番号',
        'pref_code' => '都道府県',
        'city' => '市区町村',
        'address' => '市区町村以降の住所',
        'building' => 'ビル名',
        'url' => 'ホームページURL',
        'thumb' => '画像データ',
        'file_name' => 'ファイル名',
        'greeting' => 'ひとこと欄',
      ];
    }



}
