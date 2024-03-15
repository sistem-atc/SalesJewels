<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ScopedBy([UserRegisterScope::class])]
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'ean', 'type_product_id', 'image', 'user_id',
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function type_product(): BelongsTo
    {
        return $this->BelongsTo(TypeProduct::class);
    }

    public function suitcaseproduct(): BelongsTo
    {
        return $this->belongsTo(SuitCaseProduct::class);
    }

}
