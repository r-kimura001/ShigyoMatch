<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Work;

class FavoritedMail extends ShigyoMail
{
  protected $favoriter;
  protected $work;
  private $templateName = 'mail.favorited';

  /**
   * FavoritedMail constructor.
   * @param Customer $mailReceiver
   * @param Customer $favoriter
   * @param Work $work
   */
  public function __construct(
    Customer $favoriter,
    Customer $mailReceiver,
    Work $work
  )
  {
    parent::__construct($mailReceiver);
    $this->favoriter = $favoriter;
    $this->work = $work;
  }

  /**
   * @return FavoritedMail|ShigyoMail
   */
  public function build()
  {
    return $this->view($this->templateName)
      ->subject("{$this->subjectPrefix}あなたの募集が「気になる」されました")
      ->with([
        'mailReceiverName' => $this->mailReceiver->name,
        'mailReceiverId' => $this->mailReceiver->id,
        'favoriter' => $this->favoriter,
        'work' => $this->work
      ]);
  }
}
