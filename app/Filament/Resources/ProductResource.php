<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TypeProduct;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationLabel = 'Produtos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Select::make('type_product_id')
                    ->label('Tipo de Produto')
                    ->options(TypeProduct::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('ean')
                    ->label('EAN')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Section::make('Imagem')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Imagem')->multiple()->image()->hiddenLabel()->imageEditor()
                            ->imageEditorAspectRatios([null,'16:9','4:3','1:1',])->circleCropper(),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type_product.name')
                    ->label('Tipo do Produto')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ean')
                    ->label('EAN')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Fotos')->stacked()->ring(5)->wrap()
                    ->limit(5)->limitedRemainingText()->circular(),
                ])
            ->filters([
                SelectFilter::make('type_product')
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'),
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
