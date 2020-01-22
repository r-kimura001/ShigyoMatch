<?php

namespace App\Services;


use App\Repositories\CustomerRepository;
use App\Models\Work;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Services\WorkService;
class ApplyService extends Service
{
  protected $workService;
  protected $customerRep;

  /**
   * WorkService constructor.
   * @param WorkService $workService
   */
  public function __construct(
    WorkService $workService,
    CustomerRepository $customerRep
  )
  {
    $this->workService = $workService;
    $this->customerRep = $customerRep;
  }

  /**
   * @param int $workId
   * @param array $data
   * @return mixed
   */
  public function apply(int $workId, array $data)
  {
    $work = $this->workService->workById($workId);
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
    $work = $this->workService->workById($workId);

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

  public function matches(int $customerId)
  {
    $customer = $this->customerRep->findById(['applies.work.customer', 'applies.reviews'], $customerId);
    return $customer->applies->filter(function($apply){
      return $apply->match_flag;
    });
  }

  public function matcheds(int $customerId)
  {
    $customer = $this->customerRep->findById(['works.applies.applier', 'works.applies.work', 'works.applies.reviews'], $customerId);
    $applies = $customer->works->map( function($work) {
      return $work->applies;
    })->flatten();

    return collect($applies)->filter(function($apply){
      return $apply->match_flag;
    });
  }

}
