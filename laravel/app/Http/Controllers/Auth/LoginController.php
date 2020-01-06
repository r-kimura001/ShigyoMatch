<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CustomerService;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * @var
   */
  protected $customerService;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(CustomerService $customerService)
  {
    $this->middleware('guest')->except('logout');
    $this->customerService = $customerService;
  }

  public function username()
  {
    return 'login_id';
  }

  /**
   * ログインリクエストバリデート
   *
   * @param  \Illuminate\Http\Request  $request
   * @return void
   * @throws \Illuminate\Validation\ValidationException
   */
  protected function validateLogin(Request $request)
  {
    $request->validate([
      $this->username() => 'required|string',
      'password' => 'required|string',
    ],[],[
      'login_id' => 'ログインID',
      'password' => 'パスワード'
    ]);
  }

  // ★ メソッド追加
  protected function authenticated(Request $request, $user)
  {
    return $this->customerService->customerById($user->customer_id);
  }

  protected function loggedOut(Request $request)
  {
    // セッションを再生成する
    $request->session()->regenerate();
    return response()->json();
  }


}
