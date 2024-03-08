<?php

namespace App\Filament\Resources\SuitCaseResource\Pages;

use App\Models\Stock;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SuitCaseResource;

class EditSuitCase extends EditRecord
{
    protected static string $resource = SuitCaseResource::class;

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
