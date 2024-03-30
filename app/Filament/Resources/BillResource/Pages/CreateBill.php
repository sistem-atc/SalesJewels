<?php

namespace App\Filament\Resources\BillResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use App\Filament\Resources\BillResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBill extends CreateRecord
{
    protected static string $resource = BillResource::class;
    protected ?string $heading = 'Cadastrar Fatura';

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
