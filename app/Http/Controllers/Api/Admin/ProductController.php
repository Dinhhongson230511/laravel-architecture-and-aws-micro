<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\DefaultController;
use App\Services\Api\ProductService;
use App\Models\Product;
use App\Http\Requests\Api\Admin\Product\ProductCreateRequest;
use App\Http\Requests\Api\Admin\Product\ProductUpdateRequest;

class ProductController extends DefaultController
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $response = $this->productService->getAll(10);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function show(Product $product)
    {
        $response = $this->productService->show($product);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function store(ProductCreateRequest $request)
    {
        $response = $this->productService->store($request->all());
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $response = $this->productService->update($request->all(), $product);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function destroy(Product $product)
    {
        $response = $this->productService->destroy($product);
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }

    public function  uploadImage(Request $request)
    {
        $response = $this->productService->uploadImage($request->all());
        if ($response['status']) {
            return $this->responseSuccess(
                $response['data'],
                __('common.success_message')
            );
        }
        return $this->responseBadRequest();
    }
}
