<?php

namespace App\Services;

use App\Models\Prefecture;
use App\Repositories\PrefectureRepository;

class PrefectureService extends Service
{
  protected $prefectureRep;

  /**
   * PrefectureService constructor.
   * @param PrefectureRepository $prefectureRep
   */
  public function __construct(PrefectureRepository $prefectureRep)
  {
    $this->prefectureRep = $prefectureRep;
  }

  public function all()
  {
    return $this->prefectureRep->all(Prefecture::RELATIONS_ARRAY);
  }


}
