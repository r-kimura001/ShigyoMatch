<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Mail\ScoutedMail;
use App\Services\WorkService;
use App\Services\CustomerService;
class ScoutController extends Controller
{
  protected $workService;
  protected $customerService;

  public function __construct(
    WorkService $workService,
    CustomerService $customerService
  )
  {
    $this->middleware('auth');
    $this->workService = $workService;
    $this->customerService = $customerService;
  }

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $work = $this->workService->scout($request->all());

      // メール送信処理
      $scouter = $this->customerService->customerById([], Auth::user()->id);
      $scoutedCustomer = $this->customerService->customerById(Customer::RELATIONS_ARRAY, $request->input('scouted_id'));
      Mail::to($scoutedCustomer->user->email)->send(
        new ScoutedMail($scouter, $scoutedCustomer, $work)
      );

      return response($work, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
