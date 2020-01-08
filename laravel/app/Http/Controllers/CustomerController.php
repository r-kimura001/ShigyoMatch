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
    return $this->customer();
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
        $data['file_name'] = $this->fileUploadService->uploadCustomerThumb($putPath, $data['file_name']);
      }
      if($data['deleteFlag'] === '1'){
        $deleteSrc = $customer->file_name;
        $data['file_name'] = '';
      }
      $this->customerService->update($customer, $data);
      DB::commit();
    }catch(\Exception $exception){
      DB::rollback();
      $this->fileUploadService->delete($data['file_name']);
      throw $exception;
    }

    if($data['deleteFlag'] === '1'){
      $this->fileUploadService->delete($deleteSrc);
    }

    return $this->customer();

  }






  public function customer()
  {
    return Auth::check() ? $this->customerService->customerById(Auth::user()->customer_id) : '';
  }
}
