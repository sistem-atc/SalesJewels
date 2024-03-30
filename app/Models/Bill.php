<?php

namespace App\Models;

use App\Enums\BillEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ScopedBy([UserRegisterScope::class])]
class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_id', 'customer_id', 'user_id', 'value', 'duo_date', 'state',
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
