<?php

namespace App\Services;

use App\Repositories\ProfessionTypeRepository;

class ProfessionTypeService extends Service
{
  protected $professionTypeRep;

  /**
   * CustomerService constructor.
   * @param ProfessionTypeRepository $professionTypeRep
   */
  public function __construct(ProfessionTypeRepository $professionTypeRep)
  {
    $this->professionTypeRep = $professionTypeRep;
  }

  public function all()
  {
    return $this->professionTypeRep->all();
  }

  /**
   * @return ProfessionTypeRepository
   */
  public function idByBody($body)
  {
    return $this->professionTypeRep->idByBody($body);
  }


}
