<?php

namespace App\Filament\Resources\Payroll;

use App\Filament\Resources\Payroll\PayrollTransactionsResource\Pages;
use App\Filament\Resources\Payroll\PayrollTransactionsResource\RelationManagers;
use App\Models\Company\CompanyEmployee;
use App\Models\Payroll\PayrollTransactions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PayrollTransactionsResource extends Resource
{
    protected static ?string $model = PayrollTransactions::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Payroll Processing";
    protected static ?int $navigationSort = -300;


    public static function getEloquentQuery(): Builder
    {
        return PayrollTransactions::byCompany(Auth::user()->current_company_id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payroll_id')
                    //->relationship('payroll', 'month') // Assuming "name" is a column in the payrolls table
                    ->relationship('payroll', 'month', function ($query) {
                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->whereHas('company', function ($branchQuery) {
                                $branchQuery->where('company_id', Auth::user()->current_company_id);
                            });
                        }
                    })
                    ->required()
                    ->unique()
                    ->label('Payroll'),
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
                    ->label('Employee'),
                Forms\Components\TextInput::make('gross_salary')
                    ->numeric()
                    ->step(0.01)
                    ->required()
                    ->label('Gross Salary'),
                Forms\Components\TextInput::make('allowances')
                    ->numeric()
                    ->step(0.01)
                    ->required()
                    ->label('Allowances'),
                Forms\Components\TextInput::make('deductions')
                    ->numeric()
                    ->step(0.01)
                    ->required()
                    ->label('Deductions'),
                Forms\Components\TextInput::make('net_salary')
                    ->numeric()
                    ->step(0.01)
                    ->required()
                    ->label('Net Salary'),
                Forms\Components\DatePicker::make('pay_date')
                    ->required()
                    ->label('Pay Date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('payroll.month')->label('Payroll')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('companyEmployee.user.name')->label('Employee')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('gross_salary')->label('Gross Salary')->money('USD', true)->sortable(),
                Tables\Columns\TextColumn::make('allowances')->label('Allowances')->money('USD', true)->sortable(),
                Tables\Columns\TextColumn::make('deductions')->label('Deductions')->money('USD', true)->sortable(),
                Tables\Columns\TextColumn::make('net_salary')->label('Net Salary')->money('USD', true)->sortable(),
                Tables\Columns\TextColumn::make('pay_date')->label('Pay Date')->sortable()->date(),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->sortable()->dateTime(),

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
            'index' => Pages\ListPayrollTransactions::route('/'),
            'create' => Pages\CreatePayrollTransactions::route('/create'),
            'edit' => Pages\EditPayrollTransactions::route('/{record}/edit'),
        ];
    }
}
