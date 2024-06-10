<?php
namespace App\Filament\Resources\CustomerResource\Api\Handlers;

use Spatie\QueryBuilder\QueryBuilder;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\CustomerResource;
use Illuminate\Http\Client\Request;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = CustomerResource::class;

    public function handler()
    {

        $model = static::getEloquentQuery();
        $query = QueryBuilder::for($model)
        ->withoutGlobalScopes()
        ->allowedFields($model::$allowedFields ?? [])
        ->allowedSorts($model::$allowedSorts ?? [])
        ->allowedFilters($model::$allowedFilters ?? [])
        ->paginate(request()->query('per_page'))
        ->appends(request()->query());

        return static::getApiTransformer()::collection($query);
    }
}
