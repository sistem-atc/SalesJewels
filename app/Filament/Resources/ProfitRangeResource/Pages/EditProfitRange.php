<?php

namespace App\Filament\Resources\ProfitRangeResource\Pages;

use App\Filament\Resources\ProfitRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfitRange extends EditRecord
{
    protected static string $resource = ProfitRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
