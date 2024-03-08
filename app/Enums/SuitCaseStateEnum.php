<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum SuitCaseStateEnum: string implements HasLabel, HasColor
{
    case PENDING = 'Pendente';
    case SALE = 'Em Vendas';
    case PAID = 'Paga';
    case FAILED = 'Falhou';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::SALE => 'Em Vendas',
            self::PAID => 'Paga',
            self::FAILED => 'Falhou',
        };
    }


    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::SALE => 'primary',
            self::PAID => 'success',
            self::FAILED => 'danger',
        };
    }
}
