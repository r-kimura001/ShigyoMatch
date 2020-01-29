<?php

namespace App\Http\Requests\Work;

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
      'title' => 'required|string|max:30',
      'fee' => 'nullable|integer|max:999999',
      'file_name' => 'nullable|image|max:'.self::MAX_FILE_SIZE,
      'body' => 'required|string',
      'skill_types' => 'nullable|string',
      'profession_type_id' => 'required|integer'
    ];
  }

  public function attributes()
  {
    return [
      'title' => 'タイトル',
      'fee' => '金額',
      'file_name' => '画像データ',
      'body' => '募集要項',
    ];
  }

  public function messages()
  {
    return [
      'file_name|max' => '画像データは'. self::MULTIPLE_NUM .'MB以下のファイルを指定してください'
    ];
  }


}
