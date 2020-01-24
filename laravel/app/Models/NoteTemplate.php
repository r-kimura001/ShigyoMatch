<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HandledByUser;
class NoteTemplate extends Model
{
  use SoftDeletes;
  use HandledByUser;
  protected $table = 'note_templates';

  const NOTE_SCOUT_ID = 1;
  const NOTE_MSG_ID = 2;
  const NOTE_APPLY_ID = 3;
  const NOTE_MATCH_ID = 4;
  const NOTE_TARGET_TABLES = [
    self::NOTE_SCOUT_ID => 'scouts',
    self::NOTE_MSG_ID => 'messages',
    self::NOTE_APPLY_ID => 'applies',
    self::NOTE_MATCH_ID => 'applies',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function receivers()
  {
    return $this->belongsToMany(Customer::class, 'notes', 'note_template_id', 'receiver_id');
  }

}
