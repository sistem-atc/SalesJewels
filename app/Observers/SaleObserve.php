<?php

namespace App\Observers;

use App\Enums\BillEnum;
use App\Models\Bill;
use App\Models\PaymentForm;
use App\Models\Sale;
use App\Models\SuitCaseProduct;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        $condition = Str::of(PaymentForm::where('id', '=', $sale['payment_form_id'])->first()->condition)->explode(',');
        $parcel_value = $sale['total_value'] / count($condition);

        foreach ($condition as $parcel)
        {

            $current =  Carbon::today();

            Bill::create([
                'sale_id' => $sale['id'],
                'customer_id' => $sale['customer_id'],
                'value' => $parcel_value,
                'duo_date' => $current->addDays($parcel),
                'state' => BillEnum::PENDING,
            ]);
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

        $condition = Str::of(PaymentForm::where('id', '=', $sale['payment_form_id'])->first()->condition)->explode(',');
        $parcel_value = $sale['total_value'] / count($condition);

        Bill::where('sale_id', '=', $sale['id'])
            ->update([
                'value' => $parcel_value,
            ]);

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

        Bill::where('sale_id', '=', $sale['id'])->delete();

    }

}
