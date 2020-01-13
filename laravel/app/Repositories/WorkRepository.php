<?php
declare(strict_types=1);

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
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
    return $this->getBuilder()->latest()->get();
  }
  public function paginate()
  {
    return $this->getBuilder()->with(['professionType'])->latest()->paginate(Work::COUNT_PER_PAGE);
  }

  /**
   * @param int $workId
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function workById(int $workId)
  {
    $work = $this->getBuilder()->with(['professionType']);
    return $work->where('id', $workId)->first();
  }

}
