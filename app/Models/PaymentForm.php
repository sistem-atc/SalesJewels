<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ScopedBy([UserRegisterScope::class])]
class PaymentForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'condition', 'user_id',
    ];

    public function sales(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

}
