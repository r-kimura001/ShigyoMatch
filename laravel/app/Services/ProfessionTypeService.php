<?php

namespace App\Services;

use App\Models\ProfessionType;
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
    return $this->professionTypeRep->all(ProfessionType::RELATIONS_ARRAY);
  }

  /**
   * @return ProfessionTypeRepository
   */
  public function idByBody(string $body)
  {
    return $this->professionTypeRep->idByBody($body);
  }

  /**
   * @param int $id
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  public function findById(int $id)
  {
    return $this->professionTypeRep->findById(['selectables'], $id);
  }


}
