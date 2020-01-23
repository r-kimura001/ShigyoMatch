<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Customer;

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

}
