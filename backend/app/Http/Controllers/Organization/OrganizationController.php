<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\OrganizationIndexRequest;
use App\Http\Resources\Organization\OrganizationListResource;
use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Организации
 */
class OrganizationController extends Controller
{
    private const PER_PAGE = 40;

    /** Все организации */
    public function index(OrganizationIndexRequest $request): AnonymousResourceCollection
    {
        $paginator = Organization::query()->paginate(
            perPage: self::PER_PAGE,
            page: $request->validated('page', 1),
        );

        return OrganizationListResource::collection($paginator->items())->additional([
            'meta' => [
                'last_page' => $paginator->lastPage(),
                'current_page' => $paginator->currentPage(),
            ]
        ]);
    }

    /** Данные об организации */
    public function show(Organization $organization): OrganizationResource
    {
        return new OrganizationResource($organization);
    }
}
