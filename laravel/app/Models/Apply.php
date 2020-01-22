<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Interfaces\CanDeleteRelationInterface;
class Apply extends Model implements CanDeleteRelationInterface
{
  use HandledByUser;
  use SoftDeletes;

  const COUNT_PER_PAGE = 12;
  const RELATIONS_ARRAY = ['messages', 'work.customer', 'applier'];

  protected $table = 'applies';

  public function getIsReviewAttribute()
  {
    if(Auth::guest()){
      return false;
    }
    return $this->reviews->contains(function($review){
      return $review->reviewer_id === Auth::user()->customer_id;
    });
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function messages()
  {
    return $this->hasMany(Message::class, 'apply_id', 'id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function work()
  {
    return $this->hasOne(Work::class, 'id', 'work_id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function applier()
  {
    return $this->hasOne(Customer::class, 'id', 'applier_id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function reviewers()
  {
    return $this->belongsToMany(Customer::class, 'reviews','apply_id', 'reviewer_id');
  }

  public function reviews()
  {
    return $this->hasMany(Review::class, 'apply_id', 'id');
  }

  protected $appends = ['is_review'];
  protected $hidden = ['applier_id', 'work_id'];

  public function getDeleteRelations()
  {
    return [];
  }
}
