<?php

namespace App\Filament\Resources\ProfitRangeResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProfitRangeResource;

class CreateProfitRange extends CreateRecord
{
    protected static string $resource = ProfitRangeResource::class;
    protected ?string $heading = 'Cadastrar Margem de Lucro';

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
