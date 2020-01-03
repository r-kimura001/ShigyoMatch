<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{

  public function __construct()
  {
    $this->builder = new User();
  }

  public function createByUser($userData) {
    return $this->builder->createByUser($userData);
  }

}
