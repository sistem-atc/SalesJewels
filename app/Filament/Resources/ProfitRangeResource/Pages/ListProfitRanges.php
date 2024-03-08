<?php

namespace App\Filament\Resources\ProfitRangeResource\Pages;

use App\Filament\Resources\ProfitRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfitRanges extends ListRecords
{
    protected static string $resource = ProfitRangeResource::class;
    protected ?string $heading = 'Margens de Lucro';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Cadastrar Nova Margem'),
        ];
    }
}
