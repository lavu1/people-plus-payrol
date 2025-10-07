<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\AdvanceResource\Pages;
use App\Filament\Resources\Finance\AdvanceResource\RelationManagers;
use App\Models\Finance\Advance;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AdvanceResource extends Resource
{
    protected static ?string $model = Advance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;


    public static function getEloquentQuery(): Builder
    {
        return Advance::byCompany(companyId: Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name') // Assuming `name` is a column in the `company_employees` table
                    ->required()
                    ->label('Employee'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->label('Amount'),
                Forms\Components\Textarea::make('reason')
                    ->label('Reason'),
                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Employee'),
                TextColumn::make('amount')
                    ->label('Amount'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
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
            'index' => Pages\ListAdvances::route('/'),
            'create' => Pages\CreateAdvance::route('/create'),
            'edit' => Pages\EditAdvance::route('/{record}/edit'),
        ];
    }
}
