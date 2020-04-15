<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Work;

class AuthenticatedMail extends ShigyoMail
{
  private $templateName = 'mail.authenticated';

  /**
   * AuthenticatedMail constructor.
   * @param Customer $mailReceiver
   */
  public function __construct(
    Customer $mailReceiver
  )
  {
    parent::__construct($mailReceiver);
  }

  /**
   * @return FavoritedMail|ShigyoMail
   */
  public function build()
  {
    return $this->view($this->templateName)
      ->subject("{$this->subjectPrefix}登録完了メール")
      ->with(['newCustomer' => $this->mailReceiver]);
  }
}
