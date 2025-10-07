<?php

namespace App\Filament\Resources\Allowance;

use App\Filament\Resources\Allowance\AllowanceResource\Pages;
use App\Filament\Resources\Allowance\AllowanceResource\RelationManagers;
use App\Models\Allowance\Allowance;
use App\Models\Company\Position;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AllowanceResource extends Resource
{
    protected static ?string $model = Allowance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;
    protected static ?string $navigationLabel= "Earnings";

    public static function getEloquentQuery(): Builder
    {
        return Allowance::byCompany(companyId: Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('allowance_name')
                    ->label('Allowance Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('allowance_type')
                    ->label('Allowance type')
                    ->options(['fixed', 'percentage'])
                    ->required()
                    ->searchable(),
                TextInput::make('value')
                    ->label('Value')
                    ->required()
                    ->numeric()
                    ->maxLength(10),
                TextInput::make('description')
                    ->label('Description'),
                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->relationship('company', 'company_name')
                    ->required()
                    ->searchable()
                    ->visible(Auth::user()->roles->pluck('name')->contains('super_admin')),
                Forms\Components\Select::make('position_id')
                    ->label(function ($livewire) {
                        return $livewire instanceof \Filament\Resources\Pages\EditRecord ? 'Position' : 'Positions';
                    })
                    ->options(function () {
                        $query = Position::query();

                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->whereHas('department.companyBranch', function ($branchQuery) {
                                $branchQuery->where('company_id', Auth::user()->current_company_id);
                            });
                        }

                        return $query->pluck('position_name', 'id');
                    })
                    ->required()
                    ->multiple(function ($livewire) {
                        return !($livewire instanceof \Filament\Resources\Pages\EditRecord);
                    })
                    ->default(function ($livewire) {
                        if ($livewire instanceof \Filament\Resources\Pages\EditRecord) {
                            return $livewire->record->position_id; // Single ID for edit
                        }
                        return null;
                    }),
                Toggle::make('is_taxable')
                    ->default(0)
                    ->label('Is Taxable'),
                Toggle::make('status')
                    ->default(0)
                    ->label('Status'),
                Toggle::make('recurring')
                    ->default(0)
                    ->label('Recurring'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('allowance_name')
                    ->label('Allowance Name'),
                Tables\Columns\TextColumn::make('allowance_type')
                    ->label('Allowance Type'),
//                Tables\Columns\TextColumn::make('value')
//                    ->label('Value'),
//                Tables\Columns\TextColumn::make('description')
//                    ->label('Description'),
                Tables\Columns\TextColumn::make('company.company_name')
                    ->label('Company')->visible(Auth::user()->hasRole('super_admin')),
                Tables\Columns\TextColumn::make('position.position_name')
                    ->label('Position'),
//                Tables\Columns\IconColumn::make('is_taxable')
//                    ->boolean()
//                    ->label('Is Taxable'),
//                Tables\Columns\IconColumn::make('is_statutory')
//                    ->boolean()
//                    ->label('Statutory'),
//                Tables\Columns\IconColumn::make('status')
//                    ->boolean()
//                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAllowances::route('/'),
            'create' => Pages\CreateAllowance::route('/create'),
            'edit' => Pages\EditAllowance::route('/{record}/edit'),
        ];
    }
}
