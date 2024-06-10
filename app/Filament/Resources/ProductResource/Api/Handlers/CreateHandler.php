<?php
namespace App\Filament\Resources\ProductResource\Api\Handlers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use League\Csv\Serializer\CastToArray;
use Rupadana\ApiService\Http\Handlers;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\ProductResource;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ProductResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {

        $pathApi = 'public';
        $files = [];

        $file = Storage::put($pathApi, $request->image);

        $files[] = str_replace($pathApi . '/', '', $file);

        /*foreach($request->image as $image){
            $file = Storage::put($pathApi, $image);
            $files[] = $file;
            return $files;
        }*/

        $request['user_id'] = $request->user()->id;

        $request = $request->except('image');

        $request['image'] = $files;

        $request = new Request($request);

        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Produto Criado com sucesso.");
    }
}
