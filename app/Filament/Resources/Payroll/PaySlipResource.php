<?php

namespace App\Filament\Resources\Payroll;

use App\Filament\Resources\Payroll\PaySlipResource\Pages;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Payslip;
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

class PaySlipResource extends Resource
{
    protected static ?string $model = PaySlip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Payroll Processing";
    protected static ?int $navigationSort = -300;

    public static function getEloquentQuery(): Builder
    {
        return Payslip::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('payroll_id')
                    //->relationship('payroll', 'month') // Ensure the `payroll` relationship is defined
                    ->relationship('payroll', 'month', function ($query) {
                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->whereHas('company', function ($branchQuery) {
                                $branchQuery->where('company_id', Auth::user()->current_company_id);
                            });
                        }
                    })
                    ->label('Payroll')
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
//                Select::make('company_employee_id')
//                   // ->relationship('companyEmployee.user', 'name') // Ensure `companyEmployee` relationship is defined
//                   ->relationship('companyEmployee.user', 'name', function ($query) {
//                       if (!Auth::user()->hasRole('super_admin')) {
//                           $query->whereHas('company', function ($branchQuery) {
//                               $branchQuery->where('id', Auth::user()->current_company_id);
//                           });
//                       }
//                   })
//                    ->label('Employee')
//                    ->required(),
                TextInput::make('gross_pay')
                    ->label('Gross Pay')
                    ->numeric()
                    ->required(),
                TextInput::make('net_pay')
                    ->label('Net Pay')
                    ->numeric()
                    ->required(),
                TextInput::make('deductions_total')
                    ->label('Deductions Total')
                    ->numeric(),
                TextInput::make('leave_value')
                    ->label('Leave Value')
                    ->numeric(),
                TextInput::make('gratuity_amount')
                    ->label('Gratuity Amount')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payroll.month')
                    ->label('Payroll Month'),
                TextColumn::make('companyEmployee.user.name')
                    ->label('Employee'),
                TextColumn::make('gross_pay')
                    ->label('Gross Pay'),
                TextColumn::make('net_pay')
                    ->label('Net Pay'),
                TextColumn::make('deductions_total')
                    ->label('Deductions Total'),
                TextColumn::make('leave_value')
                    ->label('Leave Value'),
                TextColumn::make('gratuity_amount')
                    ->label('Gratuity Amount'),
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
            'index' => Pages\ListPaySlips::route('/'),
            'create' => Pages\CreatePaySlip::route('/create'),
            'edit' => Pages\EditPaySlip::route('/{record}/edit'),
        ];
    }
}
