<?php

namespace App\Models\Scopes;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class UserRegisterScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {

        if(Filament::auth()->user()->id != User::role('super_admin')->first()->id){
            $builder->where('user_id', '=', Filament::auth()->user()->id);
        }
    }
}
