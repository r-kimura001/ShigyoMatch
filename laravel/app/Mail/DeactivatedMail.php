<?php

namespace App\Mail;

use App\Models\Customer;

class DeactivatedMail extends ShigyoMail
{
  private $templateName = 'mail.deactivated';

  /**
   * FollowedMail constructor.
   * @param Customer $mailReceiver
   * @param Customer $follower
   */
  public function __construct(
    Customer $mailReceiver
  )
  {
    parent::__construct($mailReceiver);
  }

  /**
   * @return FollowedMail|ShigyoMail
   */
  public function build()
  {
    return $this->view($this->templateName)
      ->subject("退会完了のお知らせ")
      ->with([
        'mailReceiverName' => $this->mailReceiver->name,
      ]);
  }
}
