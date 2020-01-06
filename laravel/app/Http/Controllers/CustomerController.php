<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Requests\Customer\StoreRequest;
use App\Services\CustomerService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
  protected $customerService;

  public function __construct(CustomerService $customerService)
  {
    $this->customerService = $customerService;
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
    return $createdCustomer;
  }






  public function customer()
  {
    return Auth::check() ? $this->customerService->customerById(Auth::user()->customer_id) : '';
  }
}
