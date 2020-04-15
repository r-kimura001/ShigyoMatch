<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;

class ShigyoMail extends Mailable
{
  use Queueable, SerializesModels;

  protected $mailReceiver;
  protected $subjectPrefix = '【ShigyoMatch】';

  /**
   * ShigyoMail constructor.
   * @param Customer $mailReceiver
   */
  public function __construct(Customer $mailReceiver)
  {
    $this->mailReceiver = $mailReceiver;
  }

  /**
   * @return ShigyoMail
   */
  public function build()
  {
    return $this->view('mail.example')
      ->with([
        'mailReceiverName' => $this->mailReceiver->name,
      ]);
  }
}
