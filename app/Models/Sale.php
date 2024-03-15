<?php

namespace App\Models;

use App\Observers\SaleObserve;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SaleObserve::class])]
#[ScopedBy([UserRegisterScope::class])]
class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id', 'suit_case_id', 'order', 'quantity', 'total_value', 'user_id',
    ];

    protected $casts = [
        'order' => 'array',
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
