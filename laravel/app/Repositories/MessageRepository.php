<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new Message();
  }

  /**
   * @param $messageData
   * @return Message
   */
  public function createByUser($messageData) {
    return $this->builder->createByUser($messageData);
  }

}
