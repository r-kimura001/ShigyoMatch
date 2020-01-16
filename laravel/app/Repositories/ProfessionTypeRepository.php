<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\ProfessionType;

class ProfessionTypeRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new ProfessionType();
  }

  public function createByUser($professionTypeData) {
    return $this->builder->createByUser($professionTypeData);
  }

  public function idByBody($body)
  {
    return $this->getBuilder()->where('body', $body)->first(['id']);
  }


}
