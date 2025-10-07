<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\MobileNetworkOperatorResource\Pages;
use App\Filament\Resources\Finance\MobileNetworkOperatorResource\RelationManagers;
use App\Models\Finance\MobileNetworkOperator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MobileNetworkOperatorResource extends Resource
{
    protected static ?string $model = MobileNetworkOperator::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\TextInput::make('operator_name')
                    ->label('Operator Name')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('operator_code')
                    ->label('Operator Code')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('max_transfer_amount')
                    ->label('Max transfer Amount')
                    ->required()
                    ->maxLength(20),
                Forms\Components\FileUpload::make('operator_logo_url')
                    ->label('Operator Logo')
                    ->image()
                    ->columnSpan(1)
                   // ->required()
                    ->directory('operator-logos') // Directory to store the logo
                    ->imagePreviewHeight('100') // Set image preview height
                    ->maxSize(2048) // Max size in KB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('operator_name')
                    ->label('Operator Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('operator_code')
                    ->label('Operator Code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_transfer_amount')
                    ->label('Max transfer Amount')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('operator_logo_url')
                    ->label('Operator Logo')
                    ->url('operator_logos')
                    ->height(50),
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
            'index' => Pages\ListMobileNetworkOperators::route('/'),
            'create' => Pages\CreateMobileNetworkOperator::route('/create'),
            'edit' => Pages\EditMobileNetworkOperator::route('/{record}/edit'),
        ];
    }
}
