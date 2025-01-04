<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\InvoiceAddProductsRequest;
use App\Http\Requests\Invoice\InvoiceRemoveProductsRequest;
use App\Http\Requests\Invoice\InvoiceStoreRequest;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Models\Invoice;
use App\Queries\InvoiceQuery;
use Illuminate\Http\JsonResponse;

/**
 * @tags Накладные
 */
class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceQuery $invoiceQuery,
    )
    {
    }

    /** Создать */
    public function store(InvoiceStoreRequest $request): InvoiceResource
    {
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
