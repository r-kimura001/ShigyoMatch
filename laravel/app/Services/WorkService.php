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
    return $this->workRep->all(Work::RELATIONS_ARRAY);
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
    if(!empty($data['skill_types']??'')){
      $skill_types = explode(',', $data['skill_types']);
      $createdWork->skills()->sync($skill_types);
    }
    return $createdWork;
  }


  public function update(Work $work, array $data)
  {
    $work->updateByUser($data);
    if(!empty($data['skill_types']??'')){
      $skill_types = explode(',', $data['skill_types']);

    }else{
      $skill_types = [];
    }
    $work->skills()->sync($skill_types);
  }

  /**
   * @param $workId
   * @return mixed
   */
  public function workById(int $workId)
  {
    return $this->workRep->findById(Work::RELATIONS_ARRAY, $workId);
  }

  /**
   * @param int $workId
   * @param array $data
   * @return mixed
   */
  public function apply(int $workId, array $data)
  {
    $work = $this->workById($workId);
    if($work->is_owner){
      return [
        'error' => '自分の募集案件に申し込むことはできません'
      ];
    }
    if(!empty($data['pr']??'')){
      $applierData = [
        $data['applier_id'] => ['pr' => $data['pr']]
      ];
    }else{
      $applierData = [ $data['applier_id'] ];
    }

    $work->appliers()->sync($applierData);

    return $work;
  }


}
