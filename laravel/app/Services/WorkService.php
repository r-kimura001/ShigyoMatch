<?php

namespace App\Services;

use App\Repositories\WorkRepository;
use App\Models\Work;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
class WorkService extends Service
{
  protected $workRep;

  /**
   * WorkService constructor.
   * @param WorkRepository $workRep
   */
  public function __construct(
    WorkRepository $workRep
  )
  {
    $this->workRep = $workRep;
  }

  public function all()
  {
    return $this->workRep->all();
  }

  public function paginate()
  {
    return $this->workRep->paginate(Work::RELATIONS_ARRAY);
  }

  public function store($data)
  {
    // worksへの登録
    $work = new Work();
    $createdWork = $work->createByUser($data);

    return $createdWork;
  }


  public function update(Work $work, array $data)
  {
    $work->updateByUser($data);
  }

  /**
   * @param $workId
   * @return mixed
   */
  public function workById(int $workId)
  {
    return $this->workRep->findById(Work::RELATIONS_ARRAY, $workId);
  }


}
