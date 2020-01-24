<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HandledByUser;
use Illuminate\Support\Facades\Auth;
class Message extends Model
{
  use SoftDeletes;
  use HandledByUser;

  protected $table = 'messages';

  protected $fillable = ['sender_id', 'apply_id', 'body'];

  public function getIsOwnAttribute()
  {
    return $this->attributes['sender_id'] === Auth::user()->customer_id;
  }

  /**
   * @return bool
   */
  public function getIsNoteAttribute()
  {
    if(Auth::guest()){
      return false;
    }elseif(!$this->note){
      return false;
    }else {
      return $this->note->receiver_id === Auth::user()->customer_id;
    }
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function note()
  {
    return $this->hasOne(MessageNote::class, 'message_id', 'id');
  }

  protected $appends = ['is_own', 'is_note'];
  protected $hidden = ['sender_id', 'apply_id'];

}
