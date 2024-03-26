<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
