<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Helpers\CustomHelpers;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CustomerResource;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
    protected ?string $heading = 'Cadastrar Cliente';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['user_id'] = Filament::auth()->user()->id;
        $data['cpf'] = CustomHelpers::sanitize($data['cpf']);

        return $data;
    }
}
