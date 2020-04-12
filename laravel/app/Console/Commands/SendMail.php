<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShigyoMail;

class SendMail extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'send_mail';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'メールを送信します';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    Mail::to('rcr126126@gmail.com')->send(new ShigyoMail());
  }
}
