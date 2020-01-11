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

  public function createByUser($customerData) {
    return $this->builder->createByUser($customerData);
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
    return $this->getBuilder()->with(['professionTypes'])->latest()->paginate(Customer::COUNT_PER_PAGE);
  }

  /**
   * @param int $customerId
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function customerById(int $customerId)
  {
    $customer = $this->getBuilder()->with(['professionTypes', 'user']);
    return $customer->where('id', $customerId)->first();
  }

}
