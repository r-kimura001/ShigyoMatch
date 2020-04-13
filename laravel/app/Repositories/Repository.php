<?php
declare(strict_types=1);

namespace App\Repositories;
/**
 * @Class Repository
 * Repositoryの基底クラス
 */

use \Illuminate\Database\Eloquent\Model;

class Repository
{
  const COUNT_PER_PAGE = 12;

  /** @var Model このリポジトリで使用するモデル */
  protected $builder;

  public function getBuilder()
  {
    return $this->builder->query();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function all(array $relations)
  {
    return $this->getBuilder()->with($relations)->orderBy('id', 'asc')->get();
  }

  /**
   * @param array $relations
   * @param int $id
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  public function findById(array $relations,int $id)
  {
    $eloquent = $this->getBuilder()->with($relations);
    return $eloquent->where('id', $id)->first();
  }
}
