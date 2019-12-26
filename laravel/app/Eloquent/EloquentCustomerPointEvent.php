<?php

declare(strict_types=1);

namespace App\Eloquent;

use App\Models\PointEvent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquent\EloquentCustomerPointEvent
 *
 * @property int $id
 * @property int $customer_id
 * @property string $event
 * @property int $point
 * @property string $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\EloquentCustomerPointEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\EloquentCustomerPointEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquent\EloquentCustomerPointEvent query()
 * @mixin \Eloquent
 */
final class EloquentCustomerPointEvent extends Model
{
  protected $table = 'customer_point_events';
  // 自動設定されるタイムスタンプは不要
  public $timestamps = false;

  /**
   * @param PointEvent $event
   */
  public function register(PointEvent $event)
  {
    $new = $this->newInstance();
    $new->customer_id = $event->getCustomerId();
    $new->event = $event->getEvent();
    $new->point = $event->getPoint();
    $new->created_at = $event->getCreatedAt();
    $new->save();
  }
}
