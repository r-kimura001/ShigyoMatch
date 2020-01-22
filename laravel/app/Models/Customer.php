<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use App\Models\ProfessionType;
use App\Models\Prefecture;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Interfaces\CanDeleteRelationInterface;

class Customer extends Model implements CanDeleteRelationInterface
{
  use HandledByUser;
  use SoftDeletes;

  const TEST_ID = 1;
  const COUNT_PER_PAGE = 12;
  const RELATIONS_ARRAY = [ 'professionTypes', 'user', 'works.skills', 'works.professionType', 'applyWorks'];

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
   * リレーション - 投稿した募集案件
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function works()
  {
    return $this->hasMany(Work::class, 'customer_id', 'id');
  }

  /**
   * リレーション - スカウトを受けた案件
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function scoutedWorks()
  {
    return $this->belongsToMany(Work::class, 'scouts', 'scouted_id', 'work_id')->withPivot('title', 'body')->withTimestamps();
  }

  /**
   * リレーション - 申込をした募集案件
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function applyWorks()
  {
    return $this->belongsToMany(Work::class, 'applies', 'applier_id', 'work_id')->withPivot('id', 'pr', 'match_flag')->withTimestamps();
  }

  /**
   * リレーション - 申込件数
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function applies()
  {
    return $this->hasMany(Apply::class, 'applier_id', 'id');
  }

  /**
   * リレーション - カスタマーが気になるした案件
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function favorites()
  {
    return $this->belongsToMany(Work::class, 'favorites', 'customer_id', 'work_id')->withTimestamps();
  }

  /**
   * リレーション - カスタマー（Auth::user）がした評価
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function reviews()
  {
    return $this->belongsToMany(Apply::class, 'reviews', 'reviewer_id', 'apply_id')->withTimestamps()->withPivot('point', 'comment', 'reviewee_id');
  }

  protected $appends = [ 'full_address' ];

  public function getDeleteRelations()
  {
    return [$this->user, $this->works];
  }




}
