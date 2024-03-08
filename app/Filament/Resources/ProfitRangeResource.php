<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\PtbrMoney;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProfitRange;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProfitRangeResource\Pages;

class ProfitRangeResource extends Resource
{
    protected static ?string $model = ProfitRange::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Configurações';
    protected static ?string $navigationLabel = 'Margens de Lucro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                PtbrMoney::make('rangeinitial')
                    ->label('Intervalo Inicial'),
                PtbrMoney::make('rangefinal')
                    ->label('Intervalo Final'),
                Forms\Components\TextInput::make('percent')
                    ->label('Percentual')
                    ->suffix('%')
                    ->maxLength(3)
                    ->required()
                    ->numeric(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rangeinitial')
                    ->label('Intervalo Inicial')
                    ->prefix('R$ ')
                    ->numeric(decimalPlaces: 2,decimalSeparator: ',',thousandsSeparator: '.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rangefinal')
                    ->label('Intervalo Final')
                    ->numeric(decimalPlaces: 2,decimalSeparator: ',',thousandsSeparator: '.')
                    ->prefix('R$ ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('percent')
                    ->label('Porcentagem')
                    ->suffix('%')
                    ->sortable(),
            ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                /*Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),*/
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfitRanges::route('/'),
            'create' => Pages\CreateProfitRange::route('/create'),
            'edit' => Pages\EditProfitRange::route('/{record}/edit'),
            'view' => Pages\ViewProfitRange::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                //SoftDeletingScope::class,
            ]);
    }
}
