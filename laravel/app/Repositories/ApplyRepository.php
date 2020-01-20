<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Apply;

class ApplyRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new Apply();
  }

  public function createByUser($customerData)
  {
    return $this->builder->createByUser($customerData);
  }

}
