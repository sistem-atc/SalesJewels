<?php

namespace App\Filament\Resources\TypeProductResource\Pages;

use App\Filament\Resources\TypeProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTypeProduct extends CreateRecord
{
    protected static string $resource = TypeProductResource::class;
    protected ?string $heading = 'Cadastrar Tipo de Produto';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
