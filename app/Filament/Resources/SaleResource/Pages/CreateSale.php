<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Models\SuitCase;
use Filament\Facades\Filament;
use App\Enums\SuitCaseStateEnum;
use App\Filament\Resources\SaleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{

    protected static string $resource = SaleResource::class;
    protected ?string $heading = 'Criar Nova Venda';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $selectedProducts = collect($data['order'])
            ->filter(fn ($item) => !empty($item['quantity']));

        $totaQuantity = $selectedProducts->reduce(fn ($subtotal, $item) => $subtotal + $item['quantity'], 0);

        $data['payment_form_id'] =  $data['payment_form'];
        $data['suit_case_id'] = SuitCase::where('state', SuitCaseStateEnum::SALE)->first()->id;
        $data['customer_id'] = $data['customer'];
        $data['quantity'] = $totaQuantity;
        $data['user_id'] = Filament::auth()->user()->id;

        return $data;
    }

}
