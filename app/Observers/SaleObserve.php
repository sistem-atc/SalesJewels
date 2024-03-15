<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\SuitCaseProduct;

class SaleObserve
{
    public function created(Sale $sale): void
    {
        $saleProducts = $sale['order'];

        foreach ($saleProducts as $id)
        {
            SuitCaseProduct::where('product_id', $id['product_id'])
                ->decrement('quantitystock', $id['quantity']);
        }
    }

    public function updated(Sale $sale): void
    {

        $saleProductsOld = $sale->getOriginal()['order'];

        foreach ($saleProductsOld as $id)
        {
            SuitCaseProduct::query()
                ->where('product_id', $id['product_id'])
                ->increment('quantitystock', (int) $id['quantity']);
        }

        $saleProducts = $sale['order'];

        foreach ($saleProducts as $id)
        {
            SuitCaseProduct::query()
                ->where('product_id', $id['product_id'])
                ->decrement('quantitystock', $id['quantity']);
        }

    }

    public function deleted(Sale $sale): void
    {

        $saleProducts = $sale->order;

        foreach ($saleProducts as $id)
        {
            SuitCaseProduct::query()
                ->where('product_id', $id['product_id'])
                ->increment('quantitystock', (int) $id['quantity']);
        }
    }

}
