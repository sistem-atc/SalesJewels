<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ScopedBy([UserRegisterScope::class])]
class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'cpf', 'user_id',
    ];
}
