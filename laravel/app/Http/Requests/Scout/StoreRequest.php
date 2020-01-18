<?php

namespace App\Http\Requests\Scout;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        'title' => 'required|string',
        'body' => 'required|string',
        'scouted_id' => 'required|integer',
        'work_id' => 'required|integer'
      ];
    }
  public function attributes()
  {
    return [
      'title' => 'タイトル',
      'body' => 'メッセージ本文',
      'scouted_id' => 'スカウトのお相手のID',
      'work_id' => '募集案件のID',
    ];
  }
}
