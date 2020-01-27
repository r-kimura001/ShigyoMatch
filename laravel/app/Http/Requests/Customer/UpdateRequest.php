<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
  const MULTIPLE_NUM = 8;
  const MAX_FILE_SIZE = 1024 * self::MULTIPLE_NUM; //8M
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
      'login_id' => 'required|regex:/^[a-zA-Z0-9]+$/|min:6|max:20|unique:users,login_id,'.Auth::user()->login_id.',login_id',
      'email' => 'required|email|unique:users,email,'.Auth::user()->email.',email',
      'name' => 'required|max:100',
      'zip_code' => 'nullable|integer|max:9999999',
      'pref_code' => 'nullable|integer|max:47',
      'city' => 'nullable|string|max:50',
      'address' => 'nullable|string|max:255',
      'building' => 'nullable|string|max:150',
      'url' => 'nullable|max:100',
      'file_name' => 'nullable|image|max:'.self::MAX_FILE_SIZE,
      'greeting' => 'nullable|max:140',
    ];
  }

  public function attributes()
  {
    return [
      'login_id' => 'ログインID',
      'email' => 'メールアドレス',
      'name' => '事務所名',
      'zip_code' => '郵便番号',
      'pref_code' => '都道府県',
      'city' => '市区町村',
      'address' => '市区町村以降の所在場所',
      'building' => 'ビル名',
      'url' => 'ホームページURL',
      'file_name' => '画像データ',
      'greeting' => 'ひとこと欄',
    ];
  }

  public function messages()
  {
    return [
      'file_name|max' => '画像データは'. self::MULTIPLE_NUM .'MB以下のファイルを指定してください',
      'login_id|regex' => 'ログインIDは半角英数字のみ使用できます'
    ];
  }


}
