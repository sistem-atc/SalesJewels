<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'ean', 'type_product_id', 'image',
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
