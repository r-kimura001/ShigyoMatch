<?php

namespace App\Repositories;

use App\Models\MessageNote;
use Illuminate\Support\Facades\Auth;
class MessageNoteRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new MessageNote();
  }

  /**
   * @param $workData
   * @return MessageNote
   */
  public function createByUser($workData) {
    return $this->builder->createByUser($workData);
  }
  /**
   * @param array $relations
   * @param int $perPage
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function paginate(int $professionTypeId, array $relations, int $perPage=parent::COUNT_PER_PAGE)
  {
    return $this->getBuilder()
      ->with($relations)
      ->where('profession_type_id', $professionTypeId)
      ->latest()
      ->paginate($perPage);
  }

}
