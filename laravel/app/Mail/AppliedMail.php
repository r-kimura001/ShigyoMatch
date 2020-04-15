<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Work;

class AppliedMail extends ShigyoMail
{
  protected $applier;
  protected $work;
  protected $targetFlag;
  private $templateName = 'mail.applied';

  /**
   * AppliedMail constructor.
   * @param Customer $applier
   * @param Customer $mailReceiver
   * @param Work $work
   */
  public function __construct(
    Customer $applier,
    Customer $mailReceiver,
    Work $work,
    string $targetFlag
  )
  {
    parent::__construct($mailReceiver);
    $this->applier = $applier;
    $this->work = $work;
    $this->targetFlag = $targetFlag;
  }

  /**
   * @return FavoritedMail|ShigyoMail
   */
  public function build()
  {
    $subject = $this->targetFlag === 'recruiter' ? 'あなたの案件に新しい応募がありました' : '応募が完了しました';

    return $this->view($this->templateName)
      ->subject( $this->subjectPrefix . $subject )
      ->with([
        'targetFlag' => $this->targetFlag,
        'mailReceiverName' => $this->mailReceiver->name,
        'applier' => $this->applier,
        'work' => $this->work,
        'jumpUrl' => config('app.url') . "/mypage/{$this->mailReceiver->id}/applies"
      ]);
  }
}
