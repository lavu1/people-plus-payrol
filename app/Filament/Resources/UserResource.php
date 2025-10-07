<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Self Service Portal";
    protected static ?int $navigationSort = -200;


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required(),

            TextInput::make('email')
                ->email()
                ->required(),

            TextInput::make('password')
                ->password()
                ->rules(['confirmed']) // Validate that password matches the confirmation field
                ->label('Password')
                ->dehydrated(fn ($state) => filled($state)) // Save only if a value is provided
                ->required(fn ($context) => $context === 'create'), // Required only for create

            TextInput::make('password_confirmation')
                ->password()
                ->label('Confirm Password')
                ->dehydrated(false) // Do not save this field to the database
                ->required(fn ($context) => $context === 'create'), // Required only for create

           Select::make('roles')->label('Role')->relationship('roles', 'name')->preload(20)->searchable()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email')->searchable(),
                TextColumn::make('roles.name') ->label('Role')->sortable()->searchable(),
             //   TextColumn::make('role.name') ->label('Role')->sortable()->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
