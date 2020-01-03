<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use App\Models\SkillType;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionType extends Model
{
  use HandledByUser;
  use SoftDeletes;

  protected $table = 'profession_types';


  /**
   * リレーション - 資格と紐付けることが許されるスキル
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function selectableSkills()
  {
    return $this->belongsToMany(SkillType::class, 'selectables', 'profession_type_id', 'skill_type_id');
  }
}
