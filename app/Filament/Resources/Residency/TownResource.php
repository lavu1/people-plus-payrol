<?php

namespace App\Filament\Resources\Residency;

use App\Filament\Resources\Residency\TownResource\Pages;
use App\Filament\Resources\Residency\TownResource\RelationManagers;
use App\Models\Residency\Town;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TownResource extends Resource
{
    protected static ?string $model = Town::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?string $navigationGroup = "Self Service Portal";
    protected static ?int $navigationSort = -200;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('town_name')
                    ->label('Town Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('province_id')
                    ->label('Province')
                    ->relationship('province', 'province_name') // Assuming `province_name` is the field in the `provinces` table
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('town_name')
                    ->label('Town Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('province.province_name') // Display the province name from the relationship
                ->label('Province')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListTowns::route('/'),
            'create' => Pages\CreateTown::route('/create'),
            'edit' => Pages\EditTown::route('/{record}/edit'),
        ];
    }
}
