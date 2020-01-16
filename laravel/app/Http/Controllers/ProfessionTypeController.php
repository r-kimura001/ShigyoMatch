<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfessionTypeService;

class ProfessionTypeController extends Controller
{
  protected $professionTypeService;

  public function __construct(ProfessionTypeService $professionTypeService)
  {
    $this->professionTypeService = $professionTypeService;
  }

  public function index()
  {
    return $this->professionTypeService->all();
  }

  /**
   * @param int $id
   */
  public function selectables($id)
  {
    $professionType = $this->professionTypeService->findById($id);
    return $professionType->selectables;

  }
}
