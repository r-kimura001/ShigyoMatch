<?php

namespace App\Repositories;
/**
 * @Class Repository
 * Repositoryの基底クラス
 */

use \Illuminate\Database\Eloquent\Model;

class Repository
{

  /** @var Model このリポジトリで使用するモデル */
  protected $builder;

  public function getBuilder()
  {
    return $this->builder->query();
  }
}
