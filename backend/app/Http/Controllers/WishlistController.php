<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wishlist\WishlistStoreRequest;
use App\Http\Requests\Wishlist\WishlistUpdateRequest;
use App\Http\Resources\WishlistProduct\WishlistProductListResource;
use App\Models\Organization;
use App\Models\WishlistProduct;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Список желаний
 */
class WishlistController extends Controller
{
    /** @var Organization|Authenticatable  */
    private Organization $organization;

    public function __construct(
        private AuthManager $authManager,
    )
    {
        $this->organization = $authManager->user();
    }

    /** Весь список */
    public function index(): AnonymousResourceCollection
    {
        return WishlistProductListResource::collection($this->organization->wishlistProducts);
    }

    /** Добавить в список */
    public function store(WishlistStoreRequest $request): AnonymousResourceCollection
    {
        $products = collect($request->validated('products'))
            ->map(fn(array $product) => $this->organization->wishlistProducts()->create($product));

        return WishlistProductListResource::collection($products);
    }

    /** Обновить список */
    public function update(WishlistUpdateRequest $request): AnonymousResourceCollection
    {
        collect($request->validated('products'))
            ->each(fn(array $product) => $this->organization
                ->wishlistProducts()
                ->find($product['id'])
                ->update($product)
            );

        $products = WishlistProduct::query()->findMany($request->validated('products.*.id'));

        return WishlistProductListResource::collection($products);
    }

    /** Удаление */
    public function delete(WishlistProduct $product): JsonResponse
    {
        $this->organization->wishlistProducts()->findOrFail($product->id)->delete();

        return new JsonResponse([
            'status' => true,
        ]);
    }
}
