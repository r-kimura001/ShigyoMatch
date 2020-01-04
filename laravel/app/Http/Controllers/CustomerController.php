<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
  public function register(Request $request)
  {
    $data = $request->all();
    $data['password'] = \Hash::make($data['password']);

    $user = new User();
    $createdUser = $user->createByUser($data);
    return $createdUser;
  }
}
