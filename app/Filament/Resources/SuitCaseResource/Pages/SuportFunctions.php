<?php

namespace App\Filament\Resources\SuitCaseResource\Pages;

use App\Enums\SuitCaseStateEnum;
use App\Filament\Forms\Components\PtbrMoney;
use App\Models\CloseSuitCase;
use App\Models\ProfitRange;
use App\Models\Stock;
use App\Models\SuitCase;
use App\Models\SuitCaseProduct;
use Filament\Notifications\Notification;

class SuportFunctions
{

    public static function BaixarMaleta($data): Notification
    {

        $status = SuitCase::where('id', $data)->select('state', 'number')->first();

        if ($status->state === SuitCaseStateEnum::PAID){
            return Notification::make()
                    ->danger()
                    ->title('Maleta ' . $status->number . ' Não Baixada')
                    ->body('Maleta com situação diferente de Em Vendas não pode ser baixada.')
                    ->send();
        }

        SuitCase::where('id', $data)
            ->update(
                ['state' => SuitCaseStateEnum::PAID]
            );

        $returnStocks = SuitCaseProduct::query()
            ->join('suit_cases', 'suit_case_products.suit_case_id', '=', 'suit_cases.id')
            ->where('suit_cases.id', $data)
            ->select('suit_case_products.id', 'suit_case_products.quantitystock', 'suit_case_products.unityvalue',
                     'suit_cases.totalvalue', 'suit_cases.number', 'suit_cases.id as suitcaseid')
            ->get();

        $noSaleTotal = 0.0;
        $suitCaseValueTotal = 0.0;

        foreach ($returnStocks as $id)
        {
            SuitCaseProduct::query()
                ->where('id', $id->id)
                ->decrement('quantitystock', $id->quantitystock);

            $noSaleTotal += $id->unityvalue * $id->quantitystock;
            $suitCaseValueTotal = $id->totalvalue;
            $numberSuitCase = $id->number;
            $suitCaseId = $id->suitcaseid;

        }

        $sales = $suitCaseValueTotal - $noSaleTotal;
        $margin = ProfitRange::where('rangeinitial', '<', $sales)->orderby('id', 'desc')->take(1)->first();
        $profit = ($margin->percent /100) * $sales;

        CloseSuitCase::create([
            'suit_case_id' => $suitCaseId,
            'saletotalvalue' => $sales,
            'balancepayable' => $sales - $profit,
            'profit' => $profit,
        ]);

        return Notification::make()
                ->success()
                ->title('Maleta ' . $numberSuitCase . ' Baixada com sucesso')
                ->body('Valor Total Vendido: ' . PtbrMoney::formatreal($sales) . 'Lucro de R$ ' .
                    PtbrMoney::formatreal($profit) . 'Saldo a Pagar de R$ ' . PtbrMoney::formatreal($sales - $profit))
                ->send();

    }

}
