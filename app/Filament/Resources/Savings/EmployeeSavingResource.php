<?php

namespace App\Filament\Resources\Savings;

use App\Filament\Resources\Savings\EmployeeSavingResource\Pages;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\SavingsTransaction;
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
use Illuminate\Support\Facades\Auth;

class EmployeeSavingResource extends Resource
{
    protected static ?string $model = SavingsTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Deductions, Benefits & Tax Management";
    protected static ?int $navigationSort = -400;

    public static function getEloquentQuery(): Builder
    {
        return SavingsTransaction::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('savings_id')
                    ->options(function () {
                        $query = CompanyEmployee::query();

                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->whereHas('department.companyBranch', function ($query) {
                                $query->where('company_id', Auth::user()->current_company_id);
                            });
                        }

                        return $query->with('savings','user')->get()->pluck('user.name', 'id');
                    }),
                Forms\Components\Select::make('payroll_id')
                    ->relationship('payroll', 'month')
                    ->required()
                    ->label('Payroll Month')
                    ->searchable(),
                Select::make('transaction_type')
                    ->label('Transaction Type')
                    ->options([
                        'Deposit' => 'Deposit',
                        'Withdraw' => 'Withdraw',
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('savings.companyEmployee.user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                    TextColumn::make('savings.companyEmployee.employee_identification_number')
                    ->label('Employee Number')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('transaction_type')
                    ->label('Transaction Type')
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->sortable(),

                    TextColumn::make('savings.companyEmployee.department.companyBranch.company.company_name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListEmployeeSavings::route('/'),
            'create' => Pages\CreateEmployeeSaving::route('/create'),
            'edit' => Pages\EditEmployeeSaving::route('/{record}/edit'),
        ];
    }
}
