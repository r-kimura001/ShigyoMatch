<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReviewService;
use Illuminate\Support\Facades\DB;
class ReviewController extends Controller
{
  protected $reviewService;

  public function __construct(
    ReviewService $reviewService
  )
  {
    $this->reviewService = $reviewService;
  }

  public function store(Request $request, $reviewerId)
  {
    DB::beginTransaction();
    try{
      $reviewer = $this->reviewService->store($request->all(), $reviewerId);
      DB::commit();
    }catch(\Exception $exception){
      DB::rollback();
      throw $exception;
    }

    return response($reviewer, 201);
  }
}
