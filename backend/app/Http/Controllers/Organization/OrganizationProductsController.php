<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationIndexRequest;
use App\Http\Requests\Organization\OrganizationProductsRequest;
use App\Http\Resources\Organization\OrganizationListResource;
use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Resources\Product\ProductListResource;
use App\Models\Organization;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Организации
 */
class OrganizationProductsController extends Controller
{
    private const PER_PAGE = 40;

    /** Товары организации */
    public function __invoke(OrganizationProductsRequest $request, Organization $organization): AnonymousResourceCollection
    {
        $paginator = $organization->products()->paginate(
            perPage: self::PER_PAGE,
            page: $request->validated('page', 1),
        );

        return ProductListResource::collection($paginator->items())->additional([
            'meta' => [
                'last_page' => $paginator->lastPage(),
                'current_page' => $paginator->currentPage(),
            ]
        ]);
    }
}
