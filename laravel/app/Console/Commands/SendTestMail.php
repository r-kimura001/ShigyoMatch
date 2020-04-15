<?php

namespace App\Console\Commands;

use App\Mail\FavoritedMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShigyoMail;
use App\Repositories\CustomerRepository;
use App\Repositories\WorkRepository;

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
  protected $customerRep;
  protected $workRep;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(
    CustomerRepository $customerRep,
    WorkRepository $workRep
  )
  {
    parent::__construct();
    $this->customerRep = $customerRep;
    $this->workRep = $workRep;
  }

  /**
   *
   */
  public function handle()
  {
    $favoriter = $this->customerRep->findById([], 1);
    $receiver = $this->customerRep->findById(['user'], 122);
    $work = $this->workRep->findById([], 1);
    Mail::to($receiver->user->email)->send(new FavoritedMail(
      $favoriter, $receiver, $work
    ));
  }
}
