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


}
