<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Requests\Customer\StoreRequest;
use App\Services\CustomerService;
use App\Models\User;
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

  public function index()
  {
    return $this->customerService->paginate();
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
    return response($this->customerService->customerById($createdCustomer->id), 201);
  }

  /**
   * @param UpdateRequest $request
   * @param int $id
   * @return CustomerService
   * @throws \Exception
   */
  public function update(UpdateRequest $request, int $id)
  {
    $customer = $this->customerService->customerById($id);
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

    return $this->customerService->customerById($id);
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function show(int $id)
  {
    return $this->customerService->customerById($id);
  }

  /**
   * @param int $id
   */
  public function worksByOwner(int $id)
  {
    return $this->customerService->worksByOwner($id);
  }

  public function favoriteWorks(int $id)
  {
    return $this->customerService->favoriteWorks($id);
  }

  public function customer()
  {
    return Auth::check() ? $this->customerService->customerById(Auth::user()->customer_id) : '';
  }
}
