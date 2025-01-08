<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\InvoiceAddProductsRequest;
use App\Http\Requests\Invoice\InvoiceIndexRequest;
use App\Http\Requests\Invoice\InvoiceRemoveProductsRequest;
use App\Http\Requests\Invoice\InvoiceStoreRequest;
use App\Http\Resources\Invoice\InvoiceListResource;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Models\Invoice;
use App\Models\Organization;
use App\Queries\InvoiceQuery;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Накладные
 */
class InvoiceController extends Controller
{
    private const PER_PAGE = 40;

    public function __construct(
        private InvoiceQuery $invoiceQuery,
    )
    {
    }

    /** Все накладные */
    public function index(AuthManager $authManager, InvoiceIndexRequest $request): AnonymousResourceCollection
    {
        /** @var Organization $organization */
        $organization = $authManager->user();

        $paginator = Invoice::query()->forOrganization($organization)->paginate(
            perPage: self::PER_PAGE,
            page: $request->validated('page', 1),
        );

        return InvoiceListResource::collection($paginator->items())->additional([
            'meta' => [
                'last_page' => $paginator->lastPage(),
                'current_page' => $paginator->currentPage(),
            ]
        ]);
    }

    /** Создать */
    public function store(InvoiceStoreRequest $request, AuthManager $authManager): InvoiceResource
    {
        if (!in_array($authManager->id(), $request->only(['supplier_id', 'customer_id']))) abort(403);

        return new InvoiceResource($this->invoiceQuery->create($request->validated()));
    }

    /** Данные о накладной */
    public function show(Invoice $invoice): InvoiceResource
    {
        return new InvoiceResource($invoice);
    }

    /** Добавить товары в накладную */
    public function addProducts(InvoiceAddProductsRequest $request, Invoice $invoice): InvoiceResource
    {
        return new InvoiceResource($this->invoiceQuery->addProducts($invoice, $request->validated('products')));
    }

    /** Удалить товары из накладной */
    public function removeProduct(InvoiceRemoveProductsRequest $request, Invoice $invoice): InvoiceResource
    {
        return new InvoiceResource($this->invoiceQuery->removeProducts($invoice, $request->validated('products')));
    }

    /** Удалить накладную */
    public function delete(Invoice $invoice): JsonResponse
    {
        $invoice->delete();

        return response()->json(['status' => true]);
    }
}
