<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HandledByUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
  use HandledByUser;
  use SoftDeletes;

  protected $table = 'works';
}
