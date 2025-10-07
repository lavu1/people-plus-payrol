<?php

namespace App\Filament\Resources\Deductions;

use App\Filament\Resources\Deductions\DeductionResource\Pages;
use App\Models\Company\Position;
use App\Models\Finance\Deduction;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DeductionResource extends Resource
{
    protected static ?string $model = Deduction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Deductions, Benefits & Tax Management";
    protected static ?int $navigationSort = -400;


    public static function getEloquentQuery(): Builder
    {
        return Deduction::byCompany(companyId: Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('company_id')
                    ->relationship('company', 'company_name')
                    ->label('Company')
                    ->required()
                    ->visible(Auth::user()->roles->pluck('name')->contains('super_admin')),
                Select::make('frequency')
                    ->options(['Monthly' => 'Monthly','One-Time'=>'One-Time'])
                    ->label('Frequency')
                    ->required(),
                TextInput::make('name')
                    ->label('Deduction Name')
                    ->required()
                    ->maxLength(255),
                Radio::make('d_type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->default('fixed')
                    ->label('Type')
                    ->required()
                    ->live(),
                TextInput::make('value')
                    ->label(fn (Get $get): string => $get('d_type') === 'fixed' ? 'Amount in ZMW' : 'Percentage Value')
                    ->numeric()
                    ->required()
                    ->rules(function (Get $get) {
                        if ($get('g_type') === 'percentage') {
                            return ['required', 'numeric', 'min:1', 'max:100'];
                        }
                        return ['required', 'numeric', 'min:0', 'max:1000'];
                    }),
//                TextInput::make('amount')
//                    ->label('Amount')
//                    ->numeric()
//                    ->nullable(),
//                TextInput::make('percentage')
//                    ->label('Percentage')
//                    ->numeric()
//                    ->nullable(),
//                Toggle::make('is_fixed')
//                    ->label('Fixed Deduction')
//                    ->default(false),
                Toggle::make('is_statutory')
                    ->label('Statutory Deduction')
                    ->default(false)
                    ->live() // React to changes in real-time
                    ->afterStateUpdated(function (Set $set, $state) {
                        // If `is_statutory` is true, force the status to "Active" and disable it
                        if ($state) {
                            $set('status', '0'); // '0' represents "Active"
                        }
                    }),

                Radio::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Not Active',
                    ])
                    ->default('0') // Default to "Active"
                    ->label('Type')
                    ->required()
                    ->disabled(fn (Get $get) => $get('is_statutory')) // Disable if `is_statutory` is true
                    ->live(),
                TextInput::make('destination')
                    ->label('Destination')
                    ->maxLength(255)
                    ->required(),
                Select::make('position_id')
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

//                Forms\Components\Select::make('selected_positions')
//                    ->multiple()
//                    ->label('Positions')
//                    // ->relationship('position_name', 'position_name')
//                    ->options(function () {
//                        $query = Position::query();
//
//                        if (!Auth::user()->hasRole('super_admin')) {
//                            $query->whereHas('department.companyBranch', function ($branchQuery) {
//                                $branchQuery->where('company_id', Auth::user()->current_company_id);
//                            });
//                        }
//
//                        return $query->pluck('position_name', 'id');
//                    })
//                Forms\Components\Select::make('position_id')
//                    ->label('Position')
//                    ->relationship('position', 'position_name', function ($query) {
//                        if (!Auth::user()->hasRole('super_admin')) {
//                            $query->whereHas('department.companyBranch', function ($branchQuery) {
//                                $branchQuery->where('company_id', Auth::user()->current_company_id);
//                            });
//                        }
//                    })
//                    ->required(),
                    //->searchable(),
//                Toggle::make('status')
//                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.company_name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Deduction Name')
                    ->sortable()
                    ->searchable(),
//                TextColumn::make('amount')
//                    ->label('Amount')
//                    ->sortable(),
//                TextColumn::make('percentage')
//                    ->label('Percentage')
//                    ->formatStateUsing(fn ($state) => $state ? "{$state}%" : null)
//                    ->sortable(),
//                Tables\Columns\IconColumn::make('is_fixed')
//                    ->boolean()
//                    ->label('Fixed'),
                Tables\Columns\IconColumn::make('is_statutory')
                    ->boolean()
                    ->label('Statutory'),
//                TextColumn::make('destination')
//                    ->label('Destination'),
                TextColumn::make('frequency')
                    ->label('Frequency')
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
            'index' => Pages\ListDeductions::route('/'),
            'create' => Pages\CreateDeduction::route('/create'),
            'edit' => Pages\EditDeduction::route('/{record}/edit'),
        ];
    }
}
