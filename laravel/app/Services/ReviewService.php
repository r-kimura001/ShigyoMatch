<?php

namespace App\Services;


use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class ReviewService extends Service
{
  protected $customerRep;

  /**
   * WorkService constructor.
   * @param WorkService $workService
   */
  public function __construct(
    CustomerRepository $customerRep
  )
  {
    $this->customerRep = $customerRep;
  }

  public function store(array $data, $reviewerId)
  {
    $reviewer = $this->customerRep->findById([], $reviewerId);
    $detachData = $data['apply_id'];
    $reviewData = [
      $data['apply_id'] => [
        'reviewee_id' => $data['reviewee_id'],
        'point' => $data['point'],
        'comment' => $data['comment']
      ]
    ];

    $reviewer->reviews()->detach($detachData);
    $reviewer->reviews()->attach($reviewData);
    return $reviewer;
  }



}
