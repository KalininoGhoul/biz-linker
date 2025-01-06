<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Organization;
use App\Models\Product;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;

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
    public function update(ProductUpdateRequest $request, Product $product, AuthManager $authManager): ProductResource
    {
        /** @var Organization $organization */
        $organization = $authManager->user();

        $organization->products()->findOrFail($product->id)->update($request->validated());

        if ($request->has('image') || $request->hasFile('image_url')) {
            $organization->products()->findOrFail($product->id)->update(['image' => $request->downloadedImagePath]);
        }

        return new ProductResource($product->refresh());
    }

    /** Данные о товаре */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /** Удаление */
    public function delete(Product $product, AuthManager $authManager): JsonResponse
    {
        /** @var Organization $organization */
        $organization = $authManager->user();

        $organization->products()->findOrFail($product->id)->delete();

        return new JsonResponse([
            'status' => true,
        ]);
    }
}
