<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\PaymentMethodResource\Pages;
use App\Filament\Resources\Finance\PaymentMethodResource\RelationManagers;
use App\Models\Finance\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('payment_method_name')
                    ->label('Payment Method Name')
                    ->required()
                    ->maxLength(255),

                Select::make('payment_method_type')
                    ->autofocus() // Autofocus the field.
                    ->noSearchResultsMessage('choose from the list')
                    ->options($options = ['mobile','bank','other'],['',''])
                    ->placeholder('Payment Method Type'),

                Forms\Components\TextInput::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_method_name')
                    ->label('Payment Method Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('payment_method_type')
                    ->label('Payment Method Type')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
