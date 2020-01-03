<?php

namespace App\Services;

use App\Repositories\SkillTypeRepository;

class SkillTypeService extends Service
{
  protected $skillTypeRep;

  /**
   * CustomerService constructor.
   * @param SkillTypeRepository $skillTypeRep
   */
  public function __construct(SkillTypeRepository $skillTypeRep)
  {
    $this->skillTypeRep = $skillTypeRep;
  }

  public function all()
  {
    return $this->skillTypeRep->all();
  }

  /**
   * @return SkillTypeRepository
   */
  public function idByBody($body)
  {
    return $this->skillTypeRep->idByBody($body);
  }


}
