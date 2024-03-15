<?php

namespace App\Filament\Resources\TypeProductResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TypeProductResource;

class CreateTypeProduct extends CreateRecord
{
    protected static string $resource = TypeProductResource::class;
    protected ?string $heading = 'Cadastrar Tipo de Produto';

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
