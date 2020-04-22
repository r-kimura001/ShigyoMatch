<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Work;

class ForgetPasswordMail extends ShigyoMail
{
  private $templateName = 'mail.forgetPassword';
  private $token;
  /**
   * AuthenticatedMail constructor.
   * @param Customer $mailReceiver
   */
  public function __construct(
    Customer $customer,
    string $token
  )
  {
    $this->token = $token;
  }

  /**
   * @return FavoritedMail|ShigyoMail
   */
  public function build()
  {
    return $this->view($this->templateName)
      ->subject("パスワードリセット")
      ->with(['token' => $this->token]);
  }
}
