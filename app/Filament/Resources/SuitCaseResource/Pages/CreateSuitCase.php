<?php

namespace App\Filament\Resources\SuitCaseResource\Pages;

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

}
