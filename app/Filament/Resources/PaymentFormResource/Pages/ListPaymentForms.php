<?php

namespace App\Filament\Resources\PaymentFormResource\Pages;

use App\Filament\Resources\PaymentFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentForms extends ListRecords
{
    protected static string $resource = PaymentFormResource::class;
    protected ?string $heading = 'Formas de Pagamento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Cadastrar Nova Forma de Pagamento'),
        ];
    }
}
