<?php

namespace App\Models;

use App\Enums\PaymentSaleEnum;
use App\Observers\SaleObserve;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SaleObserve::class])]
class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id', 'suit_case_id', 'order', 'quantity', 'total_value' , 'paid',
    ];

    protected $casts = [
        'order' => 'array',
        'paid' => PaymentSaleEnum::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->BelongsTo(Customer::class);
    }

    public function suit_case(): BelongsTo
    {
        return $this->belongsTo(SuitCase::class);
    }

}
