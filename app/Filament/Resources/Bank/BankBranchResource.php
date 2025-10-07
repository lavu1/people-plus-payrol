<?php

namespace App\Filament\Resources\Bank;

use App\Filament\Resources\Bank\BankBranchResource\Pages;
use App\Filament\Resources\Bank\BankBranchResource\RelationManagers;
use App\Models\Bank\Bank;
use App\Models\Bank\BankBranch;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankBranchResource extends Resource
{
    protected static ?string $model = BankBranch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = "Self Service Portal";
    protected static ?int $navigationSort = -200;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bank_id')
                    ->options(Bank::pluck('bank_name', 'id'))
                    ->label('Bank')
                    ->required()
                    ->columnSpan(2)
                    ->searchable(),
        TextInput::make('branch_name')->required()->columnSpan(2),
                Textarea::make('branch_code')->required()->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch_name')->searchable(),
                TextColumn::make('branch_code')->searchable(),
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
            'index' => Pages\ListBankBranches::route('/'),
            'create' => Pages\CreateBankBranch::route('/create'),
            'edit' => Pages\EditBankBranch::route('/{record}/edit'),
        ];
    }
}
