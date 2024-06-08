<?php
namespace App\Filament\Resources\SuitCaseResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\SuitCaseResource;
use Illuminate\Routing\Router;


class SuitCaseApiService extends ApiService
{
    protected static string | null $resource = SuitCaseResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
