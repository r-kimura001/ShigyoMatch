<?php

namespace App\Services;

use App\Repositories\ApplyRepository;
use App\Repositories\MessageRepository;
use App\Repositories\WorkRepository;
use App\Models\Apply;
use App\Models\Message;
use App\Models\MessageNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Services\CustomerService;
use App\Services\WorkService;

class MessageService extends Service
{
  protected $applyRep;
  protected $messageRep;
  protected $workRep;
  protected $customerService;
  protected $workService;

  /**
   * CustomerService constructor.
   * @param ApplyRepository $applyRep
   */
  public function __construct(
    ApplyRepository $applyRep,
    MessageRepository $messageRep,
    WorkRepository $workRep,
    CustomerService $customerService,
    WorkService $workService

  )
  {
    $this->applyRep = $applyRep;
    $this->messageRep = $messageRep;
    $this->workRep = $workRep;
    $this->customerService = $customerService;
    $this->workService = $workService;
  }

  /**
   * @param array $data
   * @return mixed
   */
  public function store(array $data)
  {
    // messagesのstore
    $apply = $this->applyRep->findById(Apply::RELATIONS_ARRAY, $data['apply_id']);
    $message = new Message();
    $message->fill($data);
    $newMessage = $apply->messages()->save($message);

    // notesのstore
    $receiver = $this->customerService->customerById([], $data['receiver_id']);
    $note = new MessageNote();
    $noteData = [
      'message_id' => $newMessage->id,
      'receiver_id' => $data['receiver_id'],
    ];
    $note->fill($noteData);
    $receiver->messageNotes()->save($note);
    return $newMessage;
  }

  /**
   * 申込一覧
   * @param int $customerId
   * @return mixed
   */
  public function appliesByOwnerWithMessage(int $customerId)
  {
    return $this->customerService->applies($customerId);
  }

  /**
   * メッセージの開通した申込の一覧
   * @param int $customerId
   * @return mixed
   */
  public function appliesByOwnerOnlyHasMessage(int $customerId)
  {
    $applies = $this->appliesByOwnerWithMessage($customerId);
    return $applies->filter(function($apply){
      return $apply->messages->count() > 0;
    })->all();
  }

  /**
   *
   * @param int $customerId
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function appliedByOwnerWithMessage(int $customerId)
  {
    return $this->workRep->worksByOwnerWithoutPaginate(['applies.messages', 'applies.applier', 'applies.work.customer'], $customerId);
  }

  /**
   * メッセージ開通済みの募集案件一覧
   * @param int $customerId
   * @return array
   */
  public function appliedByOwnerOnlyHasMessage(int $customerId)
  {
    $ownerWorks = $this->appliedByOwnerWithMessage($customerId);
    return $ownerWorks->filter(function($work){
      return $work->applies->contains(function($apply){
        return $apply->messages->count() > 0;
      });
    })->all();
  }

  public function read(int $applyId)
  {
    $apply = $this->applyRep->findById(['messages.note'], $applyId);
    $apply->messages->each(function($msg){
      if($msg->is_note){
        $msg->note->delete();
      }
    });
  }

}


