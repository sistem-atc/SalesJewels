<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum PaymentSaleEnum: string implements HasLabel, HasColor
{

    case PENDING = 'Pendente';
    case PAID = 'Pago';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::PAID => 'Pago',
        };
    }


    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::PAID => 'primary',
        };
    }

}
