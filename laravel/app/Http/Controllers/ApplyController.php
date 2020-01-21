<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WorkService;
use App\Services\ApplyService;

class ApplyController extends Controller
{
  protected $workService;
  protected $applyService;

  public function __construct(
    WorkService $workService,
    ApplyService $applyService
  )
  {
    $this->middleware('auth');
    $this->workService = $workService;
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
