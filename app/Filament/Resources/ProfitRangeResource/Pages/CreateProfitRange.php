<?php

namespace App\Filament\Resources\ProfitRangeResource\Pages;

use App\Filament\Resources\ProfitRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfitRange extends CreateRecord
{
    protected static string $resource = ProfitRangeResource::class;
    protected ?string $heading = 'Cadastrar Margem de Lucro';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
