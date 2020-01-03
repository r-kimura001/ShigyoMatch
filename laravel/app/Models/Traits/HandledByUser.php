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
    return $this->save();
  }

  /**
   * @param User $user
   */
  public function updateByUser(array $attributes)
  {
    $this->fill($attributes);
    $this->save();
  }

  /**
   * @param User $user
   * @throws \Exception
   */
  public function deleteByUser(User $user)
  {
    $this->deleted_by = $user->id;
    $this->deleted_at = Carbon::now();
    $this->save();

    if ($this instanceof CanDeleteRelationInterface) {
      foreach ($this->getDeleteRelations() as $relation) {
        if ($relation instanceof Collection) {
          $relation->each(function (Model $model) use ($user) {
            $model->deleteByUser($user);
          });
        } else {
          $relation->deleteByUser($user);
        }
      }
    }
  }

}
