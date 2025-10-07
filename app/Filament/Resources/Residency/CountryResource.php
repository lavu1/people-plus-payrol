<?php

namespace App\Filament\Resources\Residency;

use App\Filament\Resources\Residency\CountryResource\Pages;
use App\Models\Residency\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?string $navigationGroup = "Self Service Portal";
    protected static ?int $navigationSort = -200;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('alpha_2_code')
                    ->label('Alpha-2 Code')
                    ->maxLength(2)
                    ->required(),

                Forms\Components\TextInput::make('alpha_3_code')
                    ->label('Alpha-3 Code')
                    ->maxLength(3)
                    ->required(),

                Forms\Components\TextInput::make('dialing_code')
                    ->label('Dialing Code')
                    ->maxLength(10)
                    ->required(),

                Forms\Components\TextInput::make('country')
                    ->label('Country')
                    ->unique(ignoreRecord: true)
                    ->required(),

                Forms\Components\TextInput::make('nationality')
                    ->label('Nationality')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alpha_2_code')
                    ->label('Alpha-2 Code')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('alpha_3_code')
                    ->label('Alpha-3 Code')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('dialing_code')
                    ->label('Dialing Code')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nationality')
                    ->label('Nationality')
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
            /*
            */
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
