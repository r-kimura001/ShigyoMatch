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
  const RELATIONS_ARRAY = ['professionType', 'customer.user', 'customer.professionTypes', 'appliers', 'scouts.user', 'skills'];

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
  public function getIsApplierAttribute()
  {
    if(Auth::guest()){
      return false;
    }
    return $this->appliers->contains(function($applier){
      return $applier->id === Auth::user()->customer_id;
    });
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
   * @return bool
   */
  public function getIsScoutedAttribute()
  {
    if(Auth::guest()){
      return false;
    }
    return $this->scouts->contains(function($scoutMember){
      return $scoutMember->id === Auth::user()->customer_id;
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
   * @return mixed
   */
  public function getCustomerNameAttribute()
  {
    return $this->customer->name;
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
   * リレーション　- 投稿したカスタマー
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
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

  /**
   * リレーション - 申込者
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function appliers()
  {
    return $this->belongsToMany(Customer::class, 'applies', 'work_id', 'applier_id')->withPivot('pr', 'match_flag')->withTimestamps();
  }

  /**
   * リレーション - スカウトした人たち
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function scouts()
  {
    return $this->belongsToMany(Customer::class, 'scouts', 'work_id', 'scouted_id')->withPivot('title', 'body')->withTimestamps();
  }

  protected $appends = ['is_owner', 'is_favorite', 'is_applier', 'is_scouted', 'favorite_count', 'customer_name'];
  protected $hidden = ['customer_id'];

  public function getDeleteRelations()
  {
    return [];
  }
}
