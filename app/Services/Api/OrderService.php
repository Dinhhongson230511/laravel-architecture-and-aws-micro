<?php

namespace App\Services\Api;

use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\OrderRepositoryInterface;

/**
 * Class OrderService
 * @package App\Services
 */
class OrderService extends BaseService
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function show(int $id)
    {
        $order = $this->orderRepository->find($id, ['orderItems']);
        if($order) {
           return $this->responseData(true, new OrderResource($order));
        }
        return $this->responseData(false);
    }

    public function getAll(int $page)
    {
        $orders = $this->orderRepository->paginate($page, ['orderItems']);
        return $this->responseData(true, new OrderCollection($orders));
    }

    public function export() {
        $headers = [
            "Content-type" => "text/css",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0" 
        ];

        $callback = function () {
            $orders = $this->orderRepository->get();
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ["ID", "Name", "Email", "Product Title", "Price", "Quantity"]);

            // Body
            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->fullName, $order->email , "", "", ""]);
                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, ["", "", "", $orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                }
            }
        };

        $data = [
            'headers' => $headers,
            'callback' => $callback
        ];

        return $this->responseData(true, $data);
    }

    public function store(array $params)
    {
        $order = $this->orderRepository->create($params);
        if($order) {
            return $this->responseData(true, new OrderResource($order));
        }
         return $this->responseData(false);

    }

    public function chart()
    {
        $data = $this->orderRepository->chart();
        return $this->responseData(true, $data);
    }
}
