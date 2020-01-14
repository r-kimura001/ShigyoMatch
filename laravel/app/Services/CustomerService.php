<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\WorkRepository;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class CustomerService extends Service
{
  protected $customerRep;
  protected $workRep;

  /**
   * CustomerService constructor.
   * @param CustomerRepository $customerRep
   */
  public function __construct(
    CustomerRepository $customerRep,
    WorkRepository $workRep
  )
  {
    $this->customerRep = $customerRep;
    $this->workRep = $workRep;
  }

  /**
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function all()
  {
    return $this->customerRep->all();
  }

  /**
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function paginate()
  {
    return $this->customerRep->paginate(Customer::RELATIONS_ARRAY);
  }

  /**
   * @param $data
   * @return Customer
   */
  public function firstRegister($data)
  {
    // customersへの登録
    $customer = new Customer();
    $createdCustomer = $customer->createByUser($data);

    // usersへの登録
    $data['login_id'] = str_random(12);
    $data['customer_id'] = $createdCustomer->id;
    $data['password'] = \Hash::make($data['password']);
    $newUser = new User();
    event(new Registered($user = $newUser->createByUser($data)));

    // ログイン
    Auth::guard()->login($user);

    // customerと資格の紐付け
    $registerNumbers = json_decode($data['registerNumbers'], true);
    $professionIds = explode(',', $data['professionIds']);

    foreach ($professionIds as $professionId) {
      $professionTypes[$professionId] = ['register_number' => $registerNumbers[$professionId]];
    }
    $createdCustomer->professionTypes()->sync($professionTypes);
    $createdCustomer->login_id = $data['login_id'];

    return $createdCustomer;

  }

  /**
   * @param Customer $customer
   * @param array $data
   */
  public function update(Customer $customer, array $data)
  {
    $customer->updateByUser($data);
    $customer->user->updateByUser($data);

    // customer_profession_typeの登録
    $registerNumbers = json_decode($data['registerNumbers'], true);
    $professionIds = explode(',', $data['professionIds']);

    foreach ($professionIds as $professionId) {
      $professionTypes[$professionId] = ['register_number' => $registerNumbers[$professionId]];
    }
    $customer->professionTypes()->sync($professionTypes);
  }

  /**
   * @param $customerId
   * @return mixed
   */
  public function customerById(int $customerId)
  {
    return $this->customerRep->findById(Customer::RELATIONS_ARRAY, $customerId);
  }

  /**
   * @param int $customerId
   * @return mixed
   */
  public function worksByOwner(int $customerId)
  {
    return $this->workRep->worksByOwner($customerId);
  }


}

