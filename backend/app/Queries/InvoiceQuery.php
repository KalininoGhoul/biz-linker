<?php

namespace App\Queries;

use App\Models\Invoice;
use App\Models\Product;

class InvoiceQuery
{
    public function create(array $invoice): Invoice
    {
        $invoice = collect($invoice);

        $invoiceModel = Invoice::query()->create($invoice->only(['supplier_id', 'customer_id'])->toArray());

        return $this->addProducts($invoiceModel, $invoice->get('products'));
    }

    public function addProducts(Invoice $invoice, array $products): Invoice
    {
        $products = collect($products)
            ->mapWithKeys(fn(array $product) => [
                $product['id'] => ['count' => $product['count']]
            ]);

        if ($products->isNotEmpty()) {
            $invoice->products()->syncWithoutDetaching($products);
        }

        return $invoice;
    }

    public function removeProducts(Invoice $invoice, array $productIds): Invoice
    {
        $invoice->products()->detach($productIds);

        return $invoice;
    }
}
