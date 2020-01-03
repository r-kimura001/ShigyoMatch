<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\models\User;
class CustomerService extends Service
{
  protected $customerRep;

  /**
   * CustomerService constructor.
   * @param CustomerRepository $customerRep
   */
  public function __construct(CustomerRepository $customerRep)
  {
    $this->customerRep = $customerRep;
  }

  public function all()
  {
    return $this->customerRep->all();
  }


}
