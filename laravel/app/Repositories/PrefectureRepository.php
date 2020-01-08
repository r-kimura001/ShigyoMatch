<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Prefecture;

class PrefectureRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new Prefecture();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
    return $this->getBuilder()->get();
  }

}
