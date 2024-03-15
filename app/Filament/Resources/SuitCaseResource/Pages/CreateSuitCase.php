<?php

namespace App\Filament\Resources\SuitCaseResource\Pages;

use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SuitCaseResource;

class CreateSuitCase extends CreateRecord
{
    protected static string $resource = SuitCaseResource::class;
    protected ?string $heading = 'Cadastrar Maleta';
    protected ?array $products = [];

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['user_id'] = Filament::auth()->user()->id;

        return $data;
    }

}
