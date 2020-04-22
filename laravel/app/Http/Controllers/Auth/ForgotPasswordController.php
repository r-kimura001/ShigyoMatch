<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset emails and
  | includes a trait which assists in sending these notifications from
  | your application to your users. Feel free to explore this trait.
  |
  */

  use SendsPasswordResetEmails;

  public function sendPasswordResetLink(Request $request)
  {
    return $this->sendResetLinkEmail($request);
  }

  protected function sendResetLinkResponse(Request $request, $response)
  {
    return response()->json([
      'message' => 'パスワード再設定用メールを送信しました',
      'data' => $response
    ]);
  }

  /**
   * Get the response for a failed password reset link.
   *
   * @param \Illuminate\Http\Request $request
   * @param string $response
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  protected function sendResetLinkFailedResponse(Request $request, $response)
  {
    return new JsonResponse([
      'message' => 'パスワード再設定用メールの送信に失敗しました',
    ], 422 );
  }
}
