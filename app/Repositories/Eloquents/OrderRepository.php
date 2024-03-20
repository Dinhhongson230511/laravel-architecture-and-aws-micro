<?php


namespace App\Repositories\Eloquents;

use App\Repositories\Eloquents\BaseRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;

use App\Models\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function chart()
    {
        return Order::query()
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, sum(order_items.quantity * order_items.price) as sum")
        ->groupBy('date')
        ->get();
    }
}
