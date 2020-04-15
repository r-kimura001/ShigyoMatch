<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppliedMail;
use App\Services\WorkService;
use App\Services\CustomerService;
use App\Services\ApplyService;

class ApplyController extends Controller
{
  protected $workService;
  protected $customerService;
  protected $applyService;

  public function __construct(
    WorkService $workService,
    CustomerService $customerService,
    ApplyService $applyService
  )
  {
    $this->middleware('auth');
    $this->workService = $workService;
    $this->customerService = $customerService;
    $this->applyService = $applyService;
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
    public function store(Request $request, int $workId)
    {
        $work = $this->applyService->apply($workId, $request->all());

        // メール送信
        $applier = $this->customerService->customerById(['user'], $request->input('applier_id'));

        // 募集者側に送信
        $recruiter = $work->customer;
        Mail::to($work->customer->user->email)->send(new AppliedMail(
          $applier, $recruiter, $work, 'recruiter'
        ));

        // 応募者側に送信
        Mail::to($applier->user->email)->send(new AppliedMail(
          $applier, $applier, $work, 'applier'
        ));

        return response($work, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function match(Request $request, int $workId)
    {
      $data = $request->all();

      $work = $this->applyService->match($workId, $request->all());
      return $work;
    }

    /**
     * @param int $customerId
     * @return mixed
     */
    public function matches(int $customerId)
    {
        return $this->applyService->matches($customerId);
    }

    /**
     * @param int $customerId
     * @return mixed
     */
    public function matcheds(int $customerId)
    {
        return $this->applyService->matcheds($customerId);
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
