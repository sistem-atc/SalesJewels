<?php

namespace App\Models;

use App\Enums\SuitCaseStateEnum;
use App\Observers\SuitCaseObserve;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SuitCaseObserve::class])]
#[ScopedBy([UserRegisterScope::class])]
class SuitCase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number', 'state', 'totalvalue', 'user_id',
    ];

    protected $casts = [
        'state' => SuitCaseStateEnum::class,
    ];

    public function suitcaseproduct(): HasMany
    {
        return $this->hasMany(SuitCaseProduct::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }



}
