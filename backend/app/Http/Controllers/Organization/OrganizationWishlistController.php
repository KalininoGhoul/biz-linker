<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationProductsRequest;
use App\Http\Resources\WishlistProduct\WishlistProductListResource;
use App\Models\Organization;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Организации
 */
class OrganizationWishlistController extends Controller
{
    /** Список желаний организации */
    public function __invoke(OrganizationProductsRequest $request, Organization $organization): AnonymousResourceCollection
    {
        return WishlistProductListResource::collection($organization->wishlistProducts);
    }
}
