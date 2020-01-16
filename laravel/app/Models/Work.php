<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Interfaces\CanDeleteRelationInterface;
class Work extends Model implements CanDeleteRelationInterface
{
  use HandledByUser;
  use SoftDeletes;

  const COUNT_PER_PAGE = 12;
  const RELATIONS_ARRAY = ['professionType', 'skills'];

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
   * @return bool
   */
  public function getIsFavoriteAttribute()
  {
    if(Auth::guest() || count($this->favorites) === 0){
      return false;
    }
    return $this->favorites->contains( function($customer) {
      return $customer->id === Auth::user()->customer_id;
    });
  }

  /**
   * @return mixed
   */
  public function getFavoriteCountAttribute()
  {
    return $this->favorites->count();
  }

  /**
   * リレーション　- 募集案件に紐付いている資格
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function professionType()
  {
    return $this->belongsTo(ProfessionType::class, 'profession_type_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function skills()
  {
    return $this->belongsToMany(SkillType::class, 'work_skills', 'work_id', 'skill_type_id')->withTimestamps();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function favorites()
  {
    return $this->belongsToMany(Customer::class, 'favorites', 'work_id', 'customer_id')->withTimestamps();
  }

  protected $appends = ['is_owner', 'is_favorite', 'favorite_count'];

  public function getDeleteRelations()
  {
    return [];
  }
}
