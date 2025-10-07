<?php

namespace App\Filament\Resources\Payroll;

use App\Filament\Resources\Payroll\GratuityResource\Pages;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Gratuity;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GratuityResource extends Resource
{
    protected static ?string $model = Gratuity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Deductions, Benefits & Tax Management";
    protected static ?int $navigationSort = -400;


    public static function getEloquentQuery(): Builder
    {
        return Gratuity::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_employee_id')
                    ->options(function () {
                        $query = CompanyEmployee::query();

                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->whereHas('department.companyBranch', function ($query) {
                                $query->where('company_id', Auth::user()->current_company_id);
                            });
                        }

                        return $query->with('user')->get()->pluck('user.name', 'id');
                    })
                    ->required(),
                Radio::make('g_type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->default('fixed')
                    ->label('Type')
                    ->required()
                    ->live(),

                TextInput::make('value')
                    ->label(fn (Get $get): string => $get('g_type') === 'fixed' ? 'Fixed Discount Amount' : 'Percentage Discount Amount')
                    ->numeric()
                    ->required()
                    ->rules(function (Get $get) {
                        if ($get('g_type') === 'percentage') {
                            return ['required', 'numeric', 'min:1', 'max:100'];
                        }
                        return ['required', 'numeric', 'min:0', 'max:1000'];
                    }),
                Radio::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->default('1')
                    ->label('Employee Status')
                    ->required()
                    ->live(),
//                Select::make('company_employee_id')
//                    //->relationship('companyEmployee.user', 'name')
//                    ->relationship('companyEmployee.user', 'name', function ($query) {
//                        if (!Auth::user()->hasRole('super_admin')) {
//                            $query->whereHas('company', function ($branchQuery) {
//                                $branchQuery->where('id', Auth::user()->current_company_id);
//                            });
//                        }
//                    })
//                    ->label('Employee')
//                    ->required(),
//                TextInput::make('value')
//                    ->label('Fixed Gratuity Amount')
//                    ->numeric()
//                    ->required(),
//                Select::make('payroll_id')
//                    ->relationship('payroll', 'month')
//                    ->label('Payroll')
//                    ->required(),
                Textarea::make('notes')
                    ->label('Notes')
                    ->placeholder('Enter any additional information...')
                    ->rows(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyEmployee.user.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
//                TextColumn::make('gratuity_amount')
//                    ->label('Gratuity Amount')
//                    ->formatStateUsing(fn ($state) => number_format($state, 2))
//                    ->sortable(),
                TextColumn::make('g_type')
                    ->label('Gratuity Type'),
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(50),
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
            'index' => Pages\ListGratuities::route('/'),
            'create' => Pages\CreateGratuity::route('/create'),
            'edit' => Pages\EditGratuity::route('/{record}/edit'),
        ];
    }
}
