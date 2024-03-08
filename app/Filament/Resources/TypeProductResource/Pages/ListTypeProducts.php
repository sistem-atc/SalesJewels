<?php

namespace App\Filament\Resources\TypeProductResource\Pages;

use App\Filament\Resources\TypeProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeProducts extends ListRecords
{
    protected static string $resource = TypeProductResource::class;
    protected ?string $heading = 'Tipo de Produtos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Criar Tipo de Produto'),
        ];
    }
}
