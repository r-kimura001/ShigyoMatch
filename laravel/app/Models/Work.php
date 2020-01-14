<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use App\Models\ProfessionType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Interfaces\CanDeleteRelationInterface;
class Work extends Model implements CanDeleteRelationInterface
{
  use HandledByUser;
  use SoftDeletes;

  const COUNT_PER_PAGE = 12;
  const RELATIONS_ARRAY = ['professionType'];

  protected $table = 'works';

  protected $fillable = ['title', 'body', 'fee', 'file_name', 'customer_id', 'profession_type_id'];

  /**
   * @return bool
   */
  public function getIsOwnerAttribute()
  {
    if(Auth::guest()){
      return false;
    }
    return $this->attributes['customer_id'] === Auth::user()->customer_id;
  }

  /**
   * リレーション　- 募集案件に紐付いている資格
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function professionType()
  {
    return $this->belongsTo(ProfessionType::class, 'profession_type_id', 'id');
  }

  protected $appends = ['is_owner'];

  public function getDeleteRelations()
  {
    return [];
  }
}
