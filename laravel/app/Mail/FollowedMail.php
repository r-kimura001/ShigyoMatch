<?php

namespace App\Mail;

use App\Models\Customer;

class FollowedMail extends ShigyoMail
{
  protected $follower;
  private $templateName = 'mail.followed';

  /**
   * FollowedMail constructor.
   * @param Customer $mailReceiver
   * @param Customer $follower
   */
  public function __construct(
    Customer $follower,
    Customer $mailReceiver
  )
  {
    parent::__construct($mailReceiver);
    $this->follower = $follower;
  }

  /**
   * @return FollowedMail|ShigyoMail
   */
  public function build()
  {
    return $this->view($this->templateName)
      ->subject("{$this->subjectPrefix}{$this->follower->name}さんにフォローされました")
      ->with([
        'mailReceiverName' => $this->mailReceiver->name,
        'mailReceiverId' => $this->mailReceiver->id,
        'follower' => $this->follower
      ]);
  }
}
