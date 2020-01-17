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

  protected $table = 'applies';

  public function getDeleteRelations()
  {
    return [];
  }
}
