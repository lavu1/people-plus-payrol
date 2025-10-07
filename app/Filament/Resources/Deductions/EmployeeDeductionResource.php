<?php

namespace App\Filament\Resources\Deductions;

use App\Filament\Resources\Deductions\EmployeeDeductionResource\Pages;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Deduction;
use App\Models\Finance\DeductionTransaction;
use App\Models\Finance\EmployeeDeduction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class EmployeeDeductionResource extends Resource
{
    protected static ?string $model = DeductionTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Deductions, Benefits & Tax Management";
    protected static ?int $navigationSort = -400;

    public static function getEloquentQuery(): Builder
    {
        return DeductionTransaction::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('deduction_id')
                    ->relationship('deduction', 'name')
                    ->label('Deduction')
                    ->required(),
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
                    ->required()
                    ->label('Employee Name'),
                Select::make('payroll_id')
                    ->relationship('payroll', 'month')
                    ->label('Payroll')
                    ->required(),
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),
                DatePicker::make('transaction_date')
                    ->label('Transaction Date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('deduction.name')
                    ->label('Deduction')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('companyEmployee.user.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payroll.month')
                    ->label('Payroll Month')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state) => number_format($state, 2)),
                TextColumn::make('transaction_date')
                    ->label('Transaction Date')
                    ->date(),
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
            'index' => Pages\ListEmployeeDeductions::route('/'),
            'create' => Pages\CreateEmployeeDeduction::route('/create'),
            'edit' => Pages\EditEmployeeDeduction::route('/{record}/edit'),
        ];
    }
}
