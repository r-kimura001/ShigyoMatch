<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Requests\Customer\StoreRequest;
use App\Services\CustomerService;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\FileUploadService;

class CustomerController extends Controller
{
  protected $customerService;
  protected $fileUploadService;

  public function __construct(
    CustomerService $customerService,
    FileUploadService $fileUploadService
  )
  {
    $this->customerService = $customerService;
    $this->fileUploadService = $fileUploadService;
  }

  /**
   * @param Request $request
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  public function index(Request $request)
  {
    return $this->customerService->customersByProfession($request->all());
  }

  /**
   * @param StoreRequest $request
   * @return CustomerService
   * @throws \Exception
   */
  public function register(StoreRequest $request)
  {
    $data = $request->all();

    DB::beginTransaction();

    try{
      $createdCustomer = $this->customerService->firstRegister($data);
      DB::commit();
    }catch(\Exception $exception){
      DB::rollback();
      throw $exception;
    }
    return response($this->customerService->customerById(Customer::RELATIONS_ARRAY, $createdCustomer->id), 201);
  }

  /**
   * @param UpdateRequest $request
   * @param int $id
   * @return CustomerService
   * @throws \Exception
   */
  public function update(UpdateRequest $request, int $id)
  {
    $customer = $this->customerService->customerById(Customer::RELATIONS_ARRAY, $id);
    $data = $request->all();
    $putPath = 'customers/'.$id;

    DB::beginTransaction();

    try{
      if(isset($data['file_name'])){
        $data['file_name'] = $this->fileUploadService->uploadThumb($putPath, $data['file_name']);
      }
      if($data['deleteFlag'] === '1'){
        $deleteSrc = $customer->file_name;
        $data['file_name'] = '';
      }
      $this->customerService->update($customer, $data);
      DB::commit();
    }catch(\Exception $exception){
      DB::rollback();
      if(isset($data['file_name'])){
        $this->fileUploadService->delete($data['file_name']);
      }
      throw $exception;
    }

    if($data['deleteFlag'] === '1'){
      $this->fileUploadService->delete($deleteSrc);
    }

    return $this->customerService->customerById(Customer::RELATIONS_ARRAY, $id);
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function show(int $id)
  {
    $relations = ['works', 'followers', 'professionTypes', 'reviewers.reviewer'];
    return $this->customerService->customerById($relations, $id);
  }

  /**
   * @param $id
   * @return mixed
   */
  public function worksByOwner(int $id)
  {
    return $this->customerService->worksByOwner($id);
  }

  /**
   * @param int $id
   * @return array
   */
  public function favoriteWorks(int $id)
  {
    return $this->customerService->favoriteWorks($id);
  }

  /**
   * @param int $id
   * @return array
   */
  public function favoritedWorks(int $id)
  {
    return $this->customerService->favoritedWorks($id);
  }

  /**
   * @param int $id
   * @return array
   */
  public function applyWorks(int $id)
  {
    return $this->customerService->applyWorks($id);
  }

  /**
   * @param int $id
   * @return array
   */
  public function appliedWorks(int $id)
  {
    return $this->customerService->appliedWorks($id);
  }

  /**
   * @param int $id
   * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function pagelessWorks(int $id)
  {
    return $this->customerService->pagelessWorks($id);
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function scoutedWorks(int $id)
  {
    return $this->customerService->scoutedWorks($id);
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function follow(int $id)
  {
    return $this->customerService->follow($id);
  }

  public function unfollow(int $id)
  {
    return $this->customerService->unfollow($id);
  }



  public function customer()
  {
    return Auth::check() ? $this->customerService->customerById(Customer::RELATIONS_ARRAY, Auth::user()->customer_id) : '';
  }
}
