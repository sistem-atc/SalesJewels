<?php

namespace App\Filament\Resources\ProfitRangeResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProfitRangeResource;

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = Filament::auth()->user()->id;

        return $data;
    }
}
