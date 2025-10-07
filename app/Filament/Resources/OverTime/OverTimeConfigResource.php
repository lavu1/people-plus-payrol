<?php

namespace App\Filament\Resources\OverTime;

use App\Filament\Resources\OverTime\OverTimeConfigResource\Pages;
use App\Filament\Resources\OverTime\OverTimeConfigResource\RelationManagers;
use App\Models\Finance\OverTimeConfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OverTimeConfigResource extends Resource
{
    protected static ?string $model = OverTimeConfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Attendance & Leave Management";
    protected static ?int $navigationSort = -500;


    public static function getEloquentQuery(): Builder
    {
        return OverTimeConfig::byCompany(Auth::user()->current_company_id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('over_time_type')
                    ->options(['weekend' => 'Weekend', 'holidays' => 'Holidays', 'excess_hours' => 'Excess-hours'])
                    ->required(),
                Forms\Components\TextInput::make('hourly_rate')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('calculation_rate')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        '0' => 'Active',
                        '1' => 'Inactive',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('is_taxable')
                    ->label('Is Taxable')
                    ->default(false),
                Forms\Components\Select::make('position_id')
                   // ->relationship('position', 'position_name')
                   ->relationship('position', 'position_name', function ($query) {
                       if (!Auth::user()->hasRole('super_admin')) {
                           $query->whereHas('department.companyBranch', function ($branchQuery) {
                               $branchQuery->where('company_id', Auth::user()->current_company_id);
                           });
                       }
                   })
                    ->required(),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'company_name')
                    ->required()
                    ->visible(Auth::user()->roles->pluck('name')->contains('super_admin')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('over_time_type')
                    ->label('Overtime Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hourly_rate')
                    ->label('Hourly Rate')
                    ->sortable(),
                Tables\Columns\TextColumn::make('calculation_rate')
                    ->label('Calculation Rate')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
                Tables\Columns\BooleanColumn::make('is_taxable')
                    ->label('Is Taxable'),
                Tables\Columns\TextColumn::make('position.position_name')
                    ->label('Position'),
                Tables\Columns\TextColumn::make('company.company_name')
                    ->label('Company'),
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
            'index' => Pages\ListOverTimeConfigs::route('/'),
            'create' => Pages\CreateOverTimeConfig::route('/create'),
            'edit' => Pages\EditOverTimeConfig::route('/{record}/edit'),
        ];
    }
}
