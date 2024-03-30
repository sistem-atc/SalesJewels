<?php

namespace App\Filament\Widgets;

use App\Enums\SuitCaseStateEnum;
use App\Models\Bill;
use App\Models\Sale;
use App\Models\SuitCase;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Valor Vendido',
                $this->totalvaluesale()
            ),
            Stat::make(
                'Valor Pendente de Recebimento',
                $this->totalvaluependent()
            ),
        ];
    }

    private function totalvaluesale(): string
    {
        $sum = 0.00;
        $currentvalue = 0.00;
        $activesuitcase = SuitCase::where('state', SuitCaseStateEnum::SALE)->first();

        if (is_null($activesuitcase))
        {
            return 'R$ 0,00';
        }

        $vendorvalue = Sale::where('suit_case_id', $activesuitcase->id)->get();
        foreach ($vendorvalue as $sumtotal)
        {
            $currentvalue += (float) $sumtotal->total_value;
            $sum += $currentvalue;
        }

        $sum = str_replace(',', '.', (string) $sum);
        $sum = number_format( (float) $sum, 2, ',', '.');
        return 'R$ ' . $sum;
    }

    private function totalvaluependent(): string
    {

        $value = Bill::where('state', 'Pendente')->pluck('value')->sum();

        if (is_null($value))
        {
            return 'R$ 0,00';
        }

        $value = str_replace(',', '.', (string) $value);
        $value = number_format( (float) $value, 2, ',', '.');
        return 'R$ ' . $value;

    }
}
