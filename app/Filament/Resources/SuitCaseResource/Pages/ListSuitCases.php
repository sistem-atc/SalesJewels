<?php

namespace App\Filament\Resources\SuitCaseResource\Pages;

use Filament\Actions;
use App\Models\SuitCase;
use App\Enums\SuitCaseStateEnum;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SuitCaseResource;
use App\Filament\Resources\SuitCaseResource\Pages\SuportFunctions;

class ListSuitCases extends ListRecords
{
    protected static string $resource = SuitCaseResource::class;
    protected ?string $heading = 'Maletas';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Cadastrar Maleta'),
            Actions\Action::make('downsuitcase')
                ->label('Baixar Maleta')
                ->color('Red')
                ->form([
                    Select::make('suitcase')
                        ->label('Selecione o Cliente')
                        ->options(
                            DB::table('suit_cases')
                            ->where('state', '=', SuitCaseStateEnum::SALE->getLabel())
                            ->where('deleted_at', null)
                            ->get()
                            ->pluck('number', 'id')
                            ->toArray()
                        )
                        ->required(),
                ])->action(fn (array $data): Notification => SuportFunctions::BaixarMaleta($data)),
        ];
    }
}
