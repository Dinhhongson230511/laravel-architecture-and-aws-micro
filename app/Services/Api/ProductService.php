<?php

namespace App\Services\Api;

use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Models\Product;
use App\Services\BaseService;
use App\Repositories\Interfaces\ProductRepositoryInterface;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService extends BaseService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
    ) {
        $this->productRepository = $productRepository;
    }

    public function show(Product $product)
    {
        return $this->responseData(true, new ProductResource($product));
    }

    public function getAll(int $page)
    {
        $products = $this->productRepository->paginate($page);
        return $this->responseData(true, new ProductCollection($products));
    }

    public function store(array $params)
    {
        // $image = $this->uploadFileLocal('images', $params['image'], 'product');
        // $params['image'] = $image['filePath'] ?? null;
        $product = $this->productRepository->create($params);
        if($product) {
            return $this->responseData(true, new ProductResource($product));
        }
         return $this->responseData(false);
    }

    public function update(array $params, Product $product)
    {
        $product = $this->productRepository->update($product->id, $params);
        if($product) {
            return $this->responseData(true, new ProductResource($product));
        }
         return $this->responseData(false);

    }

    public function destroy(Product $product)
    {
        $data = $this->productRepository->delete($product->id);
        if($data) {
            return $this->responseData(true, new ProductResource($product));
        }
        return $this->responseData(false);
    }

    public function  uploadImage(array $params)
    {
        $image = $this->uploadFileLocal('images', $params['image'], 'product');
        if($image['status']) {
            return $this->responseData(true, $image);
        }
         return $this->responseData(false);
    }
}
