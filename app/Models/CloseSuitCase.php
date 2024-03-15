<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ScopedBy([UserRegisterScope::class])]
class CloseSuitCase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'suit_case_id', 'saletotalvalue', 'balancepayable', 'profit', 'user_id',
    ];

    public function suit_case(): BelongsTo
    {
        return $this->belongsTo(SuitCase::class);
    }

}
