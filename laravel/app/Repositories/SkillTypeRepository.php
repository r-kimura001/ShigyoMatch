<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\SkillType;

class SkillTypeRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new SkillType();
  }

  public function createByUser($professionTypeData) {
    return $this->builder->createByUser($professionTypeData);
  }

  /**
   * @param $body
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  public function idByBody($body)
  {
    return $this->getBuilder()->where('body', $body)->first(['id']);
  }

}
