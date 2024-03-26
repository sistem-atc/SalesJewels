<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\UserRegisterScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

#[ScopedBy([UserRegisterScope::class])]
class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'cpf', 'user_id', 'phone'
    ];

    public function userByToken(Request $request){
        return User::find(PersonalAccessToken::findToken($request->bearerToken())->tokenable_id);
    }

    public function bill(): HasMany
    {
        return $this->HasMany(Bill::class);
    }
}
