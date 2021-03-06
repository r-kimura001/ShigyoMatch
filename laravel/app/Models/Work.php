<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Interfaces\CanDeleteRelationInterface;
use Illuminate\Database\Eloquent\Builder;

class Work extends Model implements CanDeleteRelationInterface
{
  use HandledByUser;
  use SoftDeletes;

  protected $table = 'works';
  protected $fillable = ['title', 'body', 'fee', 'file_name', 'customer_id', 'profession_type_id'];

  const COUNT_PER_PAGE = 12;
  const RELATIONS_ARRAY = [
    'professionType',
    'customer.user',
    'customer.professionTypes',
    'appliers.user',
    'appliers.professionTypes',
    'scouts.user',
    'skills',
    'applies.applier'
  ];

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
    if(Auth::guest() || $this->favorites->count() === 0){
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
    return $this->belongsToMany(Customer::class, 'applies', 'work_id', 'applier_id')->withPivot('id', 'pr', 'match_flag')->withTimestamps();
  }

  /**
   * リレーション - 申込
   * @return \Illuminate\Database\Eloquent\Relations\hasMany
   */
  public function applies()
  {
    return $this->hasMany(Apply::class, 'work_id', 'id');
  }

  /**
   * リレーション - スカウトした人たち
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function scouts()
  {
    return $this->belongsToMany(Customer::class, 'scouts', 'work_id', 'scouted_id')->withPivot('title', 'body')->withTimestamps();
  }

  protected $appends = [
    'is_owner',
    'is_favorite','is_applier',
    'is_scouted',
    'favorite_count'
  ];
  protected $hidden = ['customer_id'];

  /**
   * ソート
   * @param Builder $builder
   * @param array $filter
   */
  public function scopeOrder(Builder $builder, array $filter)
  {
    if (!empty($filter['order_by'])) {
      $orderBy = (empty($filter['order_by']) ? 'created_at' : $filter['order_by']);
      $asc = (empty($filter['asc']) ? 'asc' : $filter['asc']);
      $builder->orderBy($orderBy, $asc);
    }
  }

  public function getDeleteRelations()
  {
    return [$this->applies];
  }
}
