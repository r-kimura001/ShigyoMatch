<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use App\Models\SkillType;
use App\Models\Work;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionType extends Model
{
  use HandledByUser;
  use SoftDeletes;

  protected $table = 'profession_types';

  const RELATIONS_ARRAY = [];

  /**
   * リレーション - 資格と紐付けることが許されるスキル
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function selectables()
  {
    return $this->belongsToMany(SkillType::class, 'selectables', 'profession_type_id', 'skill_type_id');
  }

  /**
   * リレーション　- 資格に紐付いている募集案件たち
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function works()
  {
    return $this->hasMany(Work::class, 'profession_type_id', 'id');
  }

  protected $hidden = ['deleted_at'];
}
