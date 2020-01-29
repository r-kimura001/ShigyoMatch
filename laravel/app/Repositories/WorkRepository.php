<?php

namespace App\Repositories;

use App\Models\Work;

class WorkRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new Work();
  }

  /**
   * @param $workData
   * @return Work
   */
  public function createByUser($workData) {
    return $this->builder->createByUser($workData);
  }
  /**
   * @param array $relations
   * @param int $perPage
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function paginate(array $relations, array $filter, int $perPage=parent::COUNT_PER_PAGE)
  {
    $query = $this->getBuilder()
                ->with($relations)
                ->where('profession_type_id', $filter['professionTypeId']);
    $query->order($filter);
    return $query->paginate($perPage);
  }

  /**
   * @param array $relations
   * @param int $customerId
   * @param int $perPage
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function WorksByOwner(array $relations, int $customerId, int $perPage)
  {
    return $this->getBuilder()
      ->with($relations)
      ->where('customer_id', $customerId)
      ->latest()
      ->paginate($perPage);
  }

  /**
   * @param array $relations
   * @param int $customerId
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function worksByOwnerWithoutPaginate(array $relations, int $customerId)
  {
    return $this->getBuilder()
      ->with($relations)
      ->where('customer_id', $customerId)
      ->latest()
      ->get();
  }

  /**
   * @param int $customerId
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function favoritedWorks(int $customerId)
  {
    $works = $this->getBuilder()
      ->with(['professionType'])
      ->where('customer_id', $customerId)
      ->latest()
      ->get();

    return $works->where('favorite_count', '>', 0);
  }
  /**
   * @param int $customerId
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function scoutedWorks(array $relations, int $customerId)
  {
    $works = $this->getBuilder()
      ->with($relations)
      ->latest()
      ->get();

    return $works->where('is_scouted', true)->all();
  }

}
