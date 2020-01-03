<?php

namespace App\Models\Interfaces;

use App\Models\User;

interface CanDeleteRelationInterface{

  /**
   * @param User $user
   * @return void
   */
  public function deleteByUser(User $user);

  public function getDeleteRelations();

}

