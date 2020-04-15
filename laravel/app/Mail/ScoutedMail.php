<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Work;

class ScoutedMail extends ShigyoMail
{
  protected $scouter;
  protected $work;
  private $templateName = 'mail.scouted';

  /**
   * FavoritedMail constructor.
   * @param Customer $mailReceiver
   * @param Customer $favoriter
   * @param Work $work
   */
  public function __construct(
    Customer $scouter,
    Customer $mailReceiver,
    Work $work
  )
  {
    parent::__construct($mailReceiver);
    $this->scouter = $scouter;
    $this->work = $work;
  }

  /**
   * @return FavoritedMail|ShigyoMail
   */
  public function build()
  {
    return $this->view($this->templateName)
      ->subject("{$this->subjectPrefix}スカウトを受けました")
      ->with([
        'mailReceiverName' => $this->mailReceiver->name,
        'jumpUrl' => config('app.url') . "/{$this->mailReceiver->id}/scouts",
        'scouter' => $this->scouter,
        'work' => $this->work
      ]);
  }
}
