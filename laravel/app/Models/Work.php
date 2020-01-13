<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use App\Models\ProfessionType;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
  use HandledByUser;
  use SoftDeletes;

  const COUNT_PER_PAGE = 12;

  protected $table = 'works';

  protected $fillable = ['title', 'body', 'fee', 'file_name', 'customer_id', 'profession_type_id'];

  /**
   * リレーション　- 募集案件に紐付いている資格
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function professionType()
  {
    return $this->belongsTo(ProfessionType::class, 'profession_type_id', 'id');
  }
}
