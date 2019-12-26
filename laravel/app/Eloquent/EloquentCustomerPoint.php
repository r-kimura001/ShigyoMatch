<?php

declare(strict_types=1);

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquent\EloquentCustomerPoint
 *
 * @property int $customer_id
 * @property int $point
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\EloquentCustomerPoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\EloquentCustomerPoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\EloquentCustomerPoint query()
 * @mixin \Eloquent
 */
final class EloquentCustomerPoint extends Model
{
  protected $table = 'customer_points';
  // 自動設定されるタイムスタンプは不要
  public $timestamps = false;

  /**
   * @param int $customerId
   * @param int $point
   * @return bool
   */
  public function addPoint(int $customerId, int $point): bool
  {
    return $this->newQuery()
      ->where('customer_id', $customerId)
      ->update([
        $this->getConnection()->raw('point=point+?', $point)
      ]) === 1;

  }

}
