<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Hash;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserRepository;

class ResetPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */

  use ResetsPasswords;
  protected $userRep;

  public function __construct(UserRepository $userRep)
  {
    $this->userRep = $userRep;
  }

  public function callResetPassword(Request $request)
  {
    return $this->reset($request);
  }

  /**
   * Reset the given user's password.
   *
   * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
   * @param  string  $password
   * @return void
   */
  protected function resetPassword($user, $password)
  {
    $user->password = Hash::make($password);
    $user->save();
    event(new PasswordReset($user));
  }

  /**
   * Get the response for a successful password reset.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $response
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  protected function sendResetResponse(Request $request, $response)
  {

    // ログイン
    return response()->json([
      'message' => 'パスワードの再設定に成功しました。数秒後、ログイン画面に移動しますので、再度ログインを試みてください',
    ]);
  }
  /**
   * Get the response for a failed password reset.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $response
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  protected function sendResetFailedResponse(Request $request, $response)
  {
    return new JsonResponse([
      'errors' => [
        'password' => [ 'パスワード再設定に失敗しました。URLの有効期限切れなどが考えられます。' ]
      ],
      'response' => $response
    ], 422 );
  }

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = '/home';
}
