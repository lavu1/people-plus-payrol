<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\CurrencyResource\Pages;
use App\Filament\Resources\Finance\CurrencyResource\RelationManagers;
use App\Models\Finance\Currency;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('currency_name')
                    ->label('Currency Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('currency_code')
                    ->label('Currency Code')
                    ->required()
                    ->maxLength(10),
                TextInput::make('symbol')
                    ->label('Symbol')
                    ->maxLength(10),
                TextInput::make('exchange_rate')
                    ->label('Exchange Rate')
                    ->numeric()
                    ->required(),
                Toggle::make('is_active')
                    ->label('Active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('currency_name')
                    ->label('Currency Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('currency_code')
                    ->label('Currency Code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('symbol')
                    ->label('Symbol'),
                TextColumn::make('exchange_rate')
                    ->label('Exchange Rate')
                    ->formatStateUsing(fn ($state) => number_format($state, 2)),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}
