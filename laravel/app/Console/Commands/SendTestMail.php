<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShigyoMail;

class SendTestMail extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test_mail';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'テストメールを送信します。';

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
    Mail::to('sample@example.com')->send(new ShigyoMail());
  }
}
