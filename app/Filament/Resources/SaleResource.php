<?php

namespace App\Filament\Resources;

use App\Models\Sale;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Enums\PaymentSaleEnum;
use App\Models\SuitCaseProduct;
use App\Enums\SuitCaseStateEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Quantity\Components\Quantity;
use App\Filament\Forms\Components\PtbrMoney;
use App\Filament\Resources\SaleResource\Pages;
use App\Models\SuitCase;

class SaleResource extends Resource
{

    protected static ?string $model = Sale::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Vendas';
    protected static ?string $navigationLabel = 'Vendas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalhes')
                    ->schema([
                        Select::make('customer')
                            ->label('Cliente')
                            ->preload()
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('cpf')
                                    ->label('CPF')
                                    ->maxLength(255),
                            ]),
                        PtbrMoney::make('total_value')
                            ->label('Valor Total')
                            ->readOnly()
                            ->placeholder(fn ($get, $set) => self::updateTotalValue($set, $get)),
                        TextInput::make('paid')
                            ->label('Pagamento')
                            ->readOnly()
                            ->default(PaymentSaleEnum::PENDING),
                    ])->columns(3)->columnSpanFull(),
                Section::make('Vendas')
                    ->schema([
                        Repeater::make('order')
                            ->label('Produtos')
                            ->schema([
                                Select::make('product_id')
                                    ->label('Produtos')
                                    ->preload()
                                    ->options(fn($operation) => self::GetProducts($operation))
                                    ->distinct()
                                    ->live()
                                    ->reactive()
                                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateUnityValue($set, $get))
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->searchable(),
                                Quantity::make('quantity')
                                    ->required()
                                    ->minValue(0)
                                    ->numeric()
                                    ->maxValue(fn (Get $get, Set $set, $operation) => self::returnMaxQuantity($get, $set, $operation))
                                    ->label('Quantidade')
                                    ->reactive()
                                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateUnityValue($set, $get)),
                                PtbrMoney::make('unityvalue')
                                    ->label('Valor Unitario')
                                    ->readOnly()
                            ])
                            ->live()
                            ->itemLabel(fn (array $state): ?string => Product::find($state['product_id'])['name'] ?? null)
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotalValue($set, $get))
                            ->columnSpanFull()
                            ->collapsed()
                            ->columns(3),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('suit_case.number')
                    ->label('Nº da Maleta')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantidade')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_value')
                    ->label('Valor Total')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->label('Pago')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data da Venda')
                    ->searchable()
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('customer.name')
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn ($record) => SuitCase::find($record->suit_case_id)->state === SuitCaseStateEnum::PAID),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn ($record) => SuitCase::find($record->suit_case_id)->state === SuitCaseStateEnum::PAID),
            ])
            ->bulkActions([
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
            'view' => Pages\ViewSale::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                //
            ]);
    }

    public static function returnMaxQuantity(Get $get, Set $set, $operation): int
    {
        $quantity = SuitCaseProduct::where('product_id', $get('product'))->first();

        if($operation === 'create')
        {
            if (is_null($quantity)) return 0;
            return $quantity->quantitystock;

        } else {

            $originQuantity = $get('quantity');
            if (is_null($quantity)) return $originQuantity;
            return $quantity->quantitystock + $originQuantity;

        }

    }

    public static function updateUnityValue(Set $set, Get $get): void
    {
        $unit_value =
            DB::table('suit_case_products')
                ->where('suit_case_products.product_id', '=', $get('product_id'))
                ->select('suit_case_products.unityvalue')
                ->first();

        if(!is_null($unit_value) && !is_null($get('quantity'))){
            $unitValue = floatval($unit_value->unityvalue) * (int) $get('quantity');
            $set('unityvalue', PtbrMoney::formatreal($unitValue));
        }
    }

    public static function updateTotalValue(Set $set, Get $get): void
    {

        $selectedProducts = collect($get('order'))
            ->filter(
                fn ($item) => !empty($item['quantity']) && !empty($item['unityvalue'])
            );

        $totalvalue = $selectedProducts->reduce(
            fn ($subtotal, $item) => $subtotal +( (float) str_replace(',' , '.', $item['unityvalue']))
        , 0);

        $set('total_value', PtbrMoney::formatreal($totalvalue));

    }

    private static function GetProducts($operation)
    {

        if($operation === 'create')
        {
            return SuitCaseProduct::query()
                    ->join('suit_cases', 'suit_case_products.suit_case_id', '=', 'suit_cases.id')
                    ->join('products', 'suit_case_products.product_id', '=', 'products.id')
                    ->where('suit_cases.state', '=', SuitCaseStateEnum::SALE)
                    ->where('suit_case_products.quantitystock', '>', 0)
                    ->select('products.ean', 'products.id')
                    ->get()
                    ->pluck('ean', 'id')
                    ->toArray();

        } else {

            return SuitCaseProduct::query()
                        ->join('suit_cases', 'suit_case_products.suit_case_id', '=', 'suit_cases.id')
                        ->join('products', 'suit_case_products.product_id', '=', 'products.id')
                        ->select('products.ean', 'products.id')
                        ->get()
                        ->pluck('ean', 'id')
                        ->toArray();
        }

    }

}
