<?php

namespace App\Filament\Resources\CustomerResource\Api\Handlers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\SettingResource;
use App\Filament\Resources\CustomerResource;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = CustomerResource::class;
    public static bool $public = true;


    public function handler(Request $request)
    {

        $id = $request->route('id');

        $model = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $model->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        $transformer = static::getApiTransformer();

        return new $transformer($query);
    }
}
