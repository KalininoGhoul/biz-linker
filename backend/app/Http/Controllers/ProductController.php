<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Organization;
use App\Models\Product;
use Illuminate\Auth\AuthManager;

/**
 * @tags Товары
 */
class ProductController extends Controller
{
    /** Добавить */
    public function store(ProductStoreRequest $request, AuthManager $authManager): ProductResource
    {
        /** @var Organization $organization */
        $organization = $authManager->user();

        $product = $organization->products()->save(new Product(array_merge(
            $request->validated(),
            ['image' => $request->downloadedImagePath]
        )));

        return new ProductResource($product);
    }

    /** Обновить */
    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        $product->update(array_merge(
            $request->validated(),
            ['image' => $request->downloadedImagePath]
        ));

        return new ProductResource($product);
    }

    /** Данные о товаре */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
