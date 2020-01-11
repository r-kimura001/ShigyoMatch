<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use App\Models\ProfessionType;
use App\Models\Prefecture;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
  use HandledByUser;
  use SoftDeletes;

  const COUNT_PER_PAGE = 12;

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

  public function getFullAddressAttribute()
  {
    if($this->pref_code === null){
      return '';
    }else{
      return $this->getPref($this->pref_code) . $this->city . $this->address . $this->building;
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

  protected $appends = [ 'full_address' ];


}
