<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Collection;

class CustomerRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new Customer();
  }

  public function createByUser($customerData)
  {
    return $this->builder->createByUser($customerData);
  }
  /**
   * @param array $relations
   * @param int $perPage
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function paginate(array $relations, int $perPage=parent::COUNT_PER_PAGE)
  {
    return $this->getBuilder()
      ->with($relations)
      ->latest()
      ->paginate($perPage);
  }

  /**
   * @param array $relations
   * @param array $data
   * @param Collection $ids
   * @param int $perPage
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function paginateByProfession(array $relations, array $data, array $filters, int $perPage=parent::COUNT_PER_PAGE)
  {
    $orderBy = explode('.', $data['sortKey'] ?? 'created_at.desc');

    if ($filters['prefCode'] !== '0') {
      return $this->getBuilder()
        ->with($relations)
        ->whereIn('id', $filters['ids'])
        ->where('pref_code', $filters['prefCode'])
        ->orderBy($orderBy[0], $orderBy[1])
        ->paginate($perPage);
    } else {
      return $this->getBuilder()
        ->with($relations)
        ->whereIn('id', $filters['ids'])
        ->orderBy($orderBy[0], $orderBy[1])
        ->paginate($perPage);
    }
  }

  /**
   * @param array $relations
   * @param array $data
   * @param Collection $ids
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function customersByProfession(array $relations, array $data, Collection $ids)
  {
    $orderBy = explode('.', $data['sortKey'] ?? 'created_at.desc');
    return $this->getBuilder()
      ->with($relations)
      ->whereIn('id', $ids)
      ->orderBy($orderBy[0], $orderBy[1])
      ->get();
  }

}
