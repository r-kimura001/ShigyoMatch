<?php
declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\User;
use App\Models\Interfaces\CanDeleteRelationInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait HandledByUser
{
  /**
   * @param array $attributes
   */
  public function createByUser(array $attributes)
  {
    $this->fill($attributes);
    $this->save();
    return $this;
  }

  public function updateByUser(array $attributes)
  {
    $this->fill($attributes);
    $this->save();
  }

  /**
   * @param User $user
   * @throws \Exception
   */
  public function deleteByUser()
  {
    $this->deleted_at = Carbon::now();
    $this->save();

    if ($this instanceof CanDeleteRelationInterface) {
      foreach ($this->getDeleteRelations() as $relation) {
        if ($relation instanceof Collection) {
          $relation->each(function (Model $model) {
            $model->deleteByUser();
          });
        } else {
          $relation->deleteByUser();
        }
      }
    }
  }

}
