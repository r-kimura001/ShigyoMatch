<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageNote extends Model
{
  use HandledByUser;
  use SoftDeletes;

  protected $table = 'message_notes';
  protected $fillable = ['receiver_id', 'message_id'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function message()
  {
    return $this->hasOne(Message::class, 'id', 'message_id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function receiver()
  {
    return $this->hasOne(Customer::class, 'id', 'receiver_id');
  }
}
