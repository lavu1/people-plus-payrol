<?php

namespace App\Filament\Resources\Company;

use App\Filament\Resources\Company\PositionResource\Pages;
use App\Filament\Resources\Company\PositionResource\RelationManagers;
use App\Models\Company\Department;
use App\Models\Company\Position;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Employer Management";
    protected static ?int $navigationSort = -801;


    public static function getEloquentQuery(): Builder
    {
        $companyId = Auth::user()->current_company_id; // Get the current user's company ID

        return Position::byCompany($companyId);
    }



    public static function getPermissions(): array
    {
        return [
            'create_company_position',

        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                  ->relationship('department', 'department_name', function ($query) {
                      if (!Auth::user()->hasRole('super_admin')) {
                          $query->whereHas('companyBranch', function ($branchQuery) {
                              $branchQuery->where('company_id', Auth::user()->current_company_id);
                          });
                      }
                  })
                    ->required(),
                Forms\Components\TextInput::make('position_name')
                    ->rules('min:3|max:40')
                    ->label('Position Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                Repeater::make('allowances')
                    ->label('Allowances')
                    ->schema([
                        TextInput::make('allowance_name')
                            ->label('Allowance Name')
                            ->required()
                            ->maxLength(255),

                        Select::make('allowance_type')
                            ->label('Allowance Type')
                            ->options([
                                'fixed' => 'Fixed Amount',
                                'percentage' => 'Percentage',
                            ])
                            ->required()
                            ->searchable(),

                        TextInput::make('value')
                            ->label('Value')
                            ->required()
                            ->numeric()
                            ->maxLength(10),
                    ])
                    ->defaultItems(1) // Number of items shown by default
                    ->addActionLabel('Add Another Allowance') // Customize the add button text
                    ->columns(3) // Display fields in 3 columns
                    ->columnSpanFull()
                    ->maxItems(10)
                ->collapsible(),

                Repeater::make('Deductions')
                    ->label('Deductions')
                    ->schema([
                        TextInput::make('deduction_name')
                            ->label('Deduction Name')
                            ->required()
                            ->maxLength(255),

                        Select::make('deduction_type')
                            ->label('Deduction Type')
                            ->options([
                                'fixed' => 'Fixed Amount',
                                'percentage' => 'Percentage',
                            ])
                            ->required()
                            ->searchable(),

                        TextInput::make('value')
                            ->label('Value')
                            ->required()
                            ->numeric()
                            ->maxLength(10),
                    ])
                    ->defaultItems(1) // Number of items shown by default
                    ->addActionLabel('Add Another Deduction') // Customize the add button text
                    ->columns(3) // Display fields in 3 columns
                    ->columnSpanFull()
                    ->maxItems(10)
                    ->collapsible()
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('position_name')
                    ->label('Position Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.department_name')
                    ->label('Department')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.companyBranch.company.company_name')
                    ->label('Company')->label('Company')->visible(Auth::user()->hasRole('super_admin'))
                    ->sortable()
                    ->searchable()
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
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
