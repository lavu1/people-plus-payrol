<?php

namespace App\Filament\Resources\Allowance;

use App\Filament\Resources\Allowance\EmployeeAllowanceResource\Pages;
use App\Filament\Resources\Allowance\EmployeeAllowanceResource\RelationManagers;
use App\Models\Allowance\EmployeeAllowance;
use App\Models\Company\CompanyEmployee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class EmployeeAllowanceResource extends Resource
{
    protected static ?string $model = EmployeeAllowance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;
    protected static ?string $navigationLabel= "Employee Earnings";

    public static function getEloquentQuery(): Builder
    {
        return EmployeeAllowance::byCompany(Auth::user()->current_company_id);
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
                    ->required()
                    ->label('Employee Name'),
                Forms\Components\Select::make('allowances_id')
                    ->label('Allowance Name')
                    ->relationship('allowance', 'allowance_name')
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('payroll_id')
                    ->label('Payroll Period')
                    //->relationship('payroll', 'month')
                    ->relationship('payroll', 'month', function ($query) {
                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->whereHas('company', function ($branchQuery) {
                                $branchQuery->where('id', Auth::user()->current_company_id);
                            });
                        }
                    })
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('companyEmployee.user.name')
                    ->label('Employee Name'),
                Tables\Columns\TextColumn::make('allowance.allowance_name')
                    ->label('Allowance Name'),
                Tables\Columns\TextColumn::make('payroll.month')
                    ->label('Payroll Period'),
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
            'index' => Pages\ListEmployeeAllowances::route('/'),
            'create' => Pages\CreateEmployeeAllowance::route('/create'),
            'edit' => Pages\EditEmployeeAllowance::route('/{record}/edit'),
        ];
    }
}
