<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  protected $table = ['notes'];

  public function message()
  {
    return $this->hasOne(Message::class, 'id', 'target_id');
  }
}
