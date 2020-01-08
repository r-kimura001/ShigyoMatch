<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrefectureService;

class PrefectureController extends Controller
{
  protected $prefectureService;

  public function __construct(PrefectureService $prefectureService)
  {
    $this->prefectureService = $prefectureService;
  }

  public function index()
  {
    return $this->prefectureService->all() ?? abort(404);
  }
}
