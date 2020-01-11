<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends UpdateRequest
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
        'email' => 'required|email|unique:users,email',
        'name' => 'required|max:100',
        'password' => 'required|min:8|confirmed',
        'zip_code' => 'nullable|numeric|max:9999999',
        'pref_code' => 'nullable|numeric|max:47',
        'city' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:255',
        'building' => 'nullable|string|max:150',
        'url' => 'nullable|max:100',
        'thumb' => 'nullable|image:jpg、png、gif',
        'file_name' => 'nullable||max:100',
        'greeting' => 'nullable|max:140',
      ];
    }


}
