<?php

namespace App\Filament\Resources\SaleResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use App\Models\SuitCaseProduct;
use App\Enums\SuitCaseStateEnum;
use App\Filament\Resources\SaleResource;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

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
        $selectedProducts = collect($data['order'])
            ->filter(fn ($item) => !empty($item['quantity']));

        $totaQuantity = $selectedProducts->reduce(fn ($subtotal, $item) => $subtotal + $item['quantity'], 0);
        $data['quantity'] = $totaQuantity;
        $data['user_id'] = Filament::auth()->user()->id;

        return $data;
    }

}
