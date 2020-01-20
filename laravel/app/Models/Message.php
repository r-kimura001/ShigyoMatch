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

  protected $appends = ['is_own'];
  protected $hidden = ['sender_id', 'apply_id'];

}
