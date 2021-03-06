<?php

namespace App\Services;

use App\Repositories\WorkRepository;
use App\Repositories\ProfessionTypeRepository;
use App\Models\Work;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
class WorkService extends Service
{
  protected $workRep;
  protected $professionTypeRep;

  /**
   * WorkService constructor.
   * @param WorkRepository $workRep
   */
  public function __construct(
    WorkRepository $workRep,
    ProfessionTypeRepository $professionTypeRep
  )
  {
    $this->workRep = $workRep;
    $this->professionTypeRep = $professionTypeRep;
  }

  public function all()
  {
    return $this->workRep->all(Work::RELATIONS_ARRAY);
  }

  public function paginate(array $data)
  {
    return $this->workRep->paginate(Work::RELATIONS_ARRAY, $data, Work::COUNT_PER_PAGE);
  }

  /**
   * @param array $data
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  public function worksByProfession(array $data)
  {
    $relations = ['professionType', 'skills', 'customer'];
    if( empty($data['targetSkills'] ?? '') && $data['prefectureId'] === '0' ){
      return $this->workRep->paginateByProfession($relations, $data);
    } else {
      $workIds = $this->idsByFilteringFactor($data);
      return $this->workRep->paginateBySkill($relations, $data, $workIds);
    }
  }

  /**
   * @param array $data
   * @return \Illuminate\Support\Collection
   */
  public function idsByFilteringFactor(array $data)
  {
    // 分野タグで絞り込む
    if (!empty($data['targetSkills'] ?? '')) {
      $workIds = DB::table('work_skills')->whereIn('skill_type_id', $data['targetSkills'])->orderBy('skill_type_id')->get()->pluck('work_id');
    } else {
      $workIds = DB::table('works')->orderBy('id')->get()->pluck('id');
    }

    // 都道府県で絞り込む
    if( $data['prefectureId'] !== '0' ) {
      $works = $this->workRep->worksByIds(['customer'], $workIds);
      return collect($works->filter(function($work) use ($data){
        return $work->customer->pref_code == $data['prefectureId'];
      }))->pluck('id');
    }

    return $workIds;
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

  /**
   * @param int $workId
   * @param array $data
   * @return mixed
   */
  public function match(int $workId, array $data)
  {
    $work = $this->workById($workId);

    if(!$work->is_owner){
      return [
        'error' => '不正な操作の可能性があります'
      ];
    }

    $applierData = [
      $data['applier_id'] => ['match_flag' => 1]
    ];

    $work->appliers()->sync($applierData);

    return $work;
  }

  public function scout(array $data)
  {
    $work = $this->workById($data['work_id']);
    if(!$work->is_owner){
      return [
        'error' => '募集案件が不正です'
      ];
    }
    $scoutData = [
      $data['scouted_id'] => [
        'title' => $data['title'],
        'body' => $data['body'],
      ]
    ];
    $work->scouts()->attach($scoutData);

    return $work;
  }


}
