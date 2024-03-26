<?php

namespace App\Models;

use App\Enums\BillEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_id', 'customer_id', 'value', 'duo_date', 'state',
    ];

    protected $casts = [
        'state' => BillEnum::class,
        'duo_date' => 'datetime:Y-m-d',
    ];

    public function customer(): BelongsTo
    {
        return $this->BelongsTo(Customer::class);
    }

    public function sale(): BelongsTo
    {
        return $this->BelongsTo(Sale::class);
    }

}
