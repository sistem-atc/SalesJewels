<?php

namespace App\Models;

use App\Models\Scopes\StockScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuitCaseProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'quantity', 'quantitystock', 'unityvalue', 'product_id', 'suit_case_id'
    ];

    public function suit_case(): BelongsTo
    {
        return $this->BelongsTo(SuitCase::class);
    }

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }
}
