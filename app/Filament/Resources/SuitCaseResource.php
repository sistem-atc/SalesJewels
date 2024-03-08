<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\SuitCase;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\SuitCaseStateEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Forms\Components\PtbrMoney;
use App\Filament\Resources\SuitCaseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuitCaseResource extends Resource
{
    protected static ?string $model = SuitCase::class;
    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $navigationGroup = 'Maletas';
    protected static ?string $navigationLabel = 'Manutenção de Maletas';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label('Numero do Pedido')
                            ->unique(ignorable: fn ($record) => $record)
                            ->required(),
                        PtbrMoney::make('totalvalue')
                            ->label('Valor Total')
                            ->readonly()
                            ->default('0,00'),
                        Forms\Components\TextInput::make('state')
                            ->label('Estado')
                            ->unique(ignorable: fn ($record) => $record)
                            ->readonly()
                            ->default(SuitCaseStateEnum::SALE)
                ])->columns(3),
                Repeater::make('suitcaseproduct')
                    ->label('Selecione os Produtos')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->label('Produtos')
                            ->preload()
                            ->relationship('product', 'ean')
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->searchable(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantidade')
                            ->afterStateUpdated(fn (Set $set, $state) => $set('quantitystock', $state))
                            ->minValue(0)
                            ->required()
                            ->numeric(),
                        Hidden::make('quantitystock'),
                        PtbrMoney::make('unityvalue')
                            ->label('Valor Unitario')
                            ->default('0,00'),
                ])
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => Product::find($state['product_id'])['name'] ?? null)
                    ->live(debounce: 250)
                    ->afterStateUpdated(fn (Set $set, Get $get) => self::updateTotal($set, $get))
                    ->columnSpanFull()
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('Numero da Maleta')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('totalvalue')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->label('Estado')
                    ->searchable()
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data de Criação')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('number')
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn ($record) => $record->state === SuitCaseStateEnum::PAID),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn ($record) => $record->state === SuitCaseStateEnum::PAID),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListSuitCases::route('/'),
            'create' => Pages\CreateSuitCase::route('/create'),
            'edit' => Pages\EditSuitCase::route('/{record}/edit'),
            'view' => Pages\ViewSuitCase::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
            ]);
    }

    public static function updateTotal(Set $set, Get $get): void
    {

        $selectedProducts = collect($get('suitcaseproduct'))
            ->filter(
                fn ($item) => !empty($item['product_id']) && !empty($item['quantity']) && !empty($item['unityvalue'])
            );

        $totalvalue = $selectedProducts->reduce(
            fn ($subtotal, $item) => $subtotal +( (float) str_replace(',' , '.', $item['unityvalue']) * $item['quantity'])
        , 0);

        $set('totalvalue', PtbrMoney::formatreal($totalvalue));

    }

}
