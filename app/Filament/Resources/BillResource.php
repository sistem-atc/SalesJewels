<?php

namespace App\Filament\Resources;

use App\Enums\BillEnum;
use App\Models\Bill;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Forms\Components\PtbrMoney;
use App\Filament\Resources\BillResource\Pages;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Vendas';
    protected static ?string $navigationLabel = 'Faturas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sale_id')
                    ->label('Numero da Venda')
                    ->relationship('sale', 'id')
                    ->required()
                    ->disabled(),
                Select::make('customer_id')
                    ->label('Nome do Cliente')
                    ->relationship('customer', 'name')
                    ->required()
                    ->disabled(),
                PtbrMoney::make('value')
                    ->label('Valor')
                    ->required()
                    ->disabled(),
                DatePicker::make('duo_date')
                    ->label('Data de Vencimento')
                    ->required()
                    ->disabled(),
                DatePicker::make('payment_date')
                    ->label('Data do Pagamento')
                    ->required(),
                Select::make('state')
                    ->label('Estado')
                    ->required()
                    ->options(BillEnum::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sale.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duo_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
            ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn($record) => $record->state == BillEnum::PAID),
                Tables\Actions\ViewAction::make(),
                //Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
            'view' => Pages\ViewBill::route('/{record}'),
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
