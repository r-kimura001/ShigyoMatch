<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use App\Models\ProfessionType;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
  use HandledByUser;
  use SoftDeletes;


  /**
   * リレーション - カスタマーの登録資格
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function professionTypes()
  {
    return $this->belongsToMany(ProfessionType::class, 'customer_profession_types', 'customer_id', 'profession_type_id')->withPivot('register_number');
  }


}
