<?php

namespace App\Repositories;

use App\Models\Work;

class WorkRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new Work();
  }

  public function createByUser($workData) {
    return $this->builder->createByUser($workData);
  }
  /**
   * @param int $customerId
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function WorksByOwner(int $customerId)
  {
    return $this->getBuilder()
      ->with(['professionType'])
      ->where('customer_id', $customerId)
      ->latest()
      ->paginate(Work::COUNT_PER_PAGE);
  }

}
