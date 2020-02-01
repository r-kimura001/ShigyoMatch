<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\WorkRepository;
use App\Repositories\ProfessionTypeRepository;
use App\Models\Customer;
use App\Models\CustomerProfessionType;
use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class CustomerService extends Service
{
  protected $customerRep;
  protected $workRep;
  protected $professionTypeRep;

  /**
   * CustomerService constructor.
   * @param CustomerRepository $customerRep
   */
  public function __construct(
    CustomerRepository $customerRep,
    WorkRepository $workRep,
    ProfessionTypeRepository $professionTypeRep
  )
  {
    $this->customerRep = $customerRep;
    $this->workRep = $workRep;
    $this->professionTypeRep = $professionTypeRep;
  }

  /**
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function all(Array $relations)
  {
    return $this->customerRep->all($relations);
  }

  /**
   * @param array $data
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  public function customersByProfession(array $data)
  {
    $relations = ['professionTypes', 'reviewers'];
    $ids = $this->idsByProfessionType($data['professionTypeId']);
    return $this->customerRep->paginateByProfession($relations, $data, $ids);
  }

  /**
   * @param int $professionId
   * @return \Illuminate\Support\Collection
   */
  public function idsByProfessionType(int $professionId)
  {
    return DB::table('customer_profession_types')->orWhere('profession_type_id', $professionId)->orderBy('profession_type_id')->get()->pluck('customer_id');
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
    if($customer->id === Customer::TEST_ID){
      $data['login_id'] = 'testuser';
      $data['email'] = 'sample@example.com';
    }
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
  public function customerById(array $relations, int $customerId)
  {
    return $this->customerRep->findById($relations, $customerId);
  }

  /**
   * @param int $customerId
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function worksByOwner(int $customerId)
  {
    return $this->workRep->worksByOwner(Work::RELATIONS_ARRAY, $customerId, Work::COUNT_PER_PAGE);
  }

  /**
   * @param int $customerId
   * @return mixed
   */
  public function favoritedWorks(int $customerId)
  {
    return $this->workRep->favoritedWorks($customerId);
  }

  /**
   * @param int $customerId
   * @return array
   */
  public function favoriteWorks(int $customerId)
  {
    $works = $this->workRep->all(Work::RELATIONS_ARRAY);
    return $works->where('is_favorite', true);
  }

  /**
   * @param int $customerId
   * @return array
   */
  public function applyWorks(int $customerId)
  {
    $works = $this->workRep->all(Work::RELATIONS_ARRAY);
    return $works->where('is_applier', true);
  }

  /**
   * @param int $customerId
   * @return array
   */
  public function appliedWorks(int $customerId)
  {
    $works = $this->workRep->worksByOwnerWithoutPaginate(Work::RELATIONS_ARRAY, $customerId);
    return $works->filter(function($work){
      return $work->appliers->count() > 0;
    })->all();
  }

  /**
   * カスタマーが応募した案件に関するメッセージ
   *
   * @param int $customerId
   * @return mixed
   */
  public function applies(int $customerId)
  {
    $customer = $this->customerById([], $customerId);
    return $customer->applies()->with(['messages', 'applier', 'work.customer'])->get();
  }
  /**
   * カスタマーが応募した案件に関するメッセージ
   *
   * @param int $customerId
   * @return mixed
   */
  public function worksByOwnerWithoutPaginate(int $customerId)
  {
    return $this->workRep->worksByOwnerWithoutPaginate(Work::RELATIONS_ARRAY, $customerId);
  }

  /**
   * @param int $customerId
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function pagelessWorks(int $customerId)
  {
    return $this->workRep->worksByOwnerWithoutPaginate(Work::RELATIONS_ARRAY, $customerId);
  }

  public function scoutedWorks(int $customerId)
  {
    $customer = $this->customerById([], $customerId);
    return $customer->scoutedWorks()->with(Work::RELATIONS_ARRAY)->get();
  }

  public function scoutWorks(int $customerId)
  {
    $customer = $this->customerById([], $customerId);
    return $customer->scoutedWorks;
  }

  /**
   * @param int $id
   */
  public function follow(int $id)
  {
    $followee = $this->customerById(['followers'], $id);
    $followee->followers()->detach(Auth::user()->customer_id);
    $followee->followers()->attach(Auth::user()->customer_id);
    return $this->customerById(['followers'], $id);
  }
  /**
   * @param int $id
   */
  public function unfollow(int $id)
  {
    $followee = $this->customerById(['followers'], $id);
    $followee->followers()->detach(Auth::user()->customer_id);
    return $this->customerById(['followers'], $id);
  }

}

