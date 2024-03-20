<?php


namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\DefaultController;
use App\Services\Api\OrderService;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Requests\Api\Admin\Order\OrderCreateRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Gate;

class OrderController extends DefaultController
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        Gate::authorize('view', 'roles');
        $response = $this->orderService->getAll(10);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function show(Order $order)
    {
        Gate::authorize('view', 'orders');

        $response = $this->orderService->show($order->id);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function export()
    {
        $response = $this->orderService->export();
        if ($response['status']) {
            return Response::stream($response['data']['callback'], 200, $response['data']['headers']);
        }

        return $this->responseBadRequest();
    }

    public function store(OrderCreateRequest $request)
    {
        $response = $this->orderService->store($request->all());
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function chart()
    {
        $response = $this->orderService->chart();

        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

}
