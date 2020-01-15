<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Interfaces\CanDeleteRelationInterface;
use Illuminate\Support\Facades\Auth;

class Customer extends Model implements CanDeleteRelationInterface
{
  use HandledByUser;
  use SoftDeletes;

  const COUNT_PER_PAGE = 12;
  const RELATIONS_ARRAY = [ 'professionTypes', 'user', 'works' ];

  protected $fillable = [
    'name',
    'zip_code',
    'pref_code',
    'city',
    'address',
    'building',
    'url',
    'file_name',
    'greeting',
  ];

  public function getPref($id)
  {
    $prefecture = Prefecture::find($id);
    return $prefecture->name;
  }

  /**
   * @return string
   */
  public function getFullAddressAttribute()
  {
    if($this->pref_code === null){
      return '';
    }else{
      return $this->getPref($this->attributes['pref_code'])
        .$this->attributes['city']
        .$this->attributes['address']
        .$this->attributes['building'];
    }
  }
  /**
   * アクセサ - follower_count
   * @return int
   */
  public function getFollowerCountAttribute()
  {
    return $this->followers->count();
  }
  /**
   * アクセサ - followee_count
   * @return int
   */
  public function getFolloweeCountAttribute()
  {
    return $this->followees->count();
  }
  /**
   * アクセサ - is_follow
   * @return int
   */
  public function getIsFollowAttribute()
  {
    return $this->followers->contains(function($customer){
      return $customer->id === Auth::user()->customer_id;
    });
  }


  /**
   * リレーション - カスタマーの登録資格
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function professionTypes()
  {
    return $this->belongsToMany(ProfessionType::class, 'customer_profession_types', 'customer_id', 'profession_type_id')->withPivot('register_number');
  }
  /**
   * リレーション - ユーザ情報
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function user()
  {
    return $this->hasOne(User::class, 'customer_id', 'id');
  }
  /**
   * リレーション - 募集案件
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function works()
  {
    return $this->hasMany(Work::class, 'customer_id', 'id');
  }
  /**
   * リレーション - フォロワー
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function followers()
  {
    return $this->belongsToMany(Customer::class, 'follows', 'followee_id', 'follower_id')->withTimestamps();
  }
  /**
   * リレーション - フォロー
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function followees()
  {
    return $this->belongsToMany(Customer::class, 'follows', 'follower_id', 'followee_id')->withTimestamps();
  }

  protected $appends = [ 'full_address', 'follower_count', 'followee_count', 'is_follow' ];

  public function getDeleteRelations()
  {
    return [$this->user, $this->works];
  }


}
