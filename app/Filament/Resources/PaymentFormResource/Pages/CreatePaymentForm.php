<?php

namespace App\Filament\Resources\PaymentFormResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PaymentFormResource;

class CreatePaymentForm extends CreateRecord
{
    protected static string $resource = PaymentFormResource::class;
    protected ?string $heading = 'Cadastrar Forma de Pagamento';

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
