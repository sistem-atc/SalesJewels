<?php

namespace App\Filament\Resources\BillResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use App\Filament\Resources\BillResource;
use Filament\Resources\Pages\EditRecord;

class EditBill extends EditRecord
{
    protected static string $resource = BillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
            //Actions\ForceDeleteAction::make(),
            //Actions\RestoreAction::make(),
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
