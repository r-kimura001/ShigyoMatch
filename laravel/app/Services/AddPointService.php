<?php

declare(strict_types=1);

namespace App\Services;

use App\Eloquent\EloquentCustomerPointEvent;
use App\Eloquent\EloquentCustomerPoint;
use App\Models\PointEvent;
use Illuminate\Database\Connectors\ConnectorInterface;

final class AddPointService
{

  /** @var EloquentCustomerPointEvent */
  private $eloquentCustomerPointEvent;

  /** @var EloquentCustomerPoint*/
  private $eloquentCustomerPoint;

  /** @var ConnectorInterface */
  private $db;

  /**
   * AddPointService constructor.
   * @param EloquentCustomerPointEvent $eloquentCustomerPointEvent
   * @param EloquentCustomerPoint $eloquentCustomerPoint
   */
  public function __construct(
    EloquentCustomerPointEvent $eloquentCustomerPointEvent,
    EloquentCustomerPoint $eloquentCustomerPoint
  ) {
      $this->eloquentCustomerPointEvent = $eloquentCustomerPointEvent;
      $this->eloquentCustomerPoint = $eloquentCustomerPoint;
      $this->db = $eloquentCustomerPointEvent->getConnection();
  }

  /**
   * @param PointEvent $event
   * @throws \Throwable
   */
  public function add(PointEvent $event)
  {
    $this->db->transaction( function () use ($event) {
      // ポイントイベント保存
      $this->eloquentCustomerPointEvent->register($event);

      // 保有ポイント更新
      $this->eloquentCustomerPoint->addPoint(
        $event->getCustomerId(),
        $event->getPoint()
      );
    });
  }

}
