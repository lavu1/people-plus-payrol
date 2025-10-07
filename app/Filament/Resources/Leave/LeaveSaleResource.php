<?php

namespace App\Filament\Resources\Leave;

use App\Filament\Resources\Leave\LeaveSaleResource\Pages;
use App\Filament\Resources\Leave\LeaveSaleResource\RelationManagers;
use App\Models\Company\CompanyEmployee;
use App\Models\Leave\LeaveSale;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Set;
use Filament\Forms\Get;

class LeaveSaleResource extends Resource
{
    protected static ?string $model = LeaveSale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Attendance & Leave Management";
    protected static ?int $navigationSort = -500;


    public static function getEloquentQuery(): Builder
    {
        return LeaveSale::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                /*
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
                Forms\Components\TextInput::make('leave_days_sold')
                    ->label('Days Sold')
                    ->numeric()
                    ->required(),
                */
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
                    ->label('Employee Name')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        if ($state) {
                            $employee = CompanyEmployee::with('user')->find($state);
                            if ($employee && $employee->user) {
                                $set('basic_pay', $employee->salary);
                            } else {
                                $set('basic_pay', null);
                            }
                        } else {
                            $set('basic_pay', null);
                        }
                        $set('sale_amount', null);
                    }),
                Forms\Components\TextInput::make('basic_pay')
                    ->hidden()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('leave_days_sold')
                    ->label('Days Sold')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) { // Use Get object
                        $basicPay = $get('basic_pay');
                        if ($basicPay && $state) {
                            $saleAmount = ($basicPay * $state) / 26;
                            $set('sale_amount', number_format($saleAmount, 2, '.', ''));
                        } else {
                            $set('sale_amount', null);
                        }
                    }),
                Forms\Components\TextInput::make('sale_amount')
                    ->label('Amount')
                    ->readOnly()
                    ->required(),
                Select::make('payroll_id')
                    ->options(function () {
                        $query = \App\Models\Finance\Payroll::query();

                        if (!Auth::user()->hasRole('super_admin')) {
                            // $query->whereHas('department.companyBranch', function ($query) {
                            $query->where('company_id', Auth::user()->current_company_id);
                            // });
                        }

                        return $query->pluck('month', 'id');
                    })
                    ->label('Payroll'),
                   // ->required(),
                Forms\Components\Select::make('status')
                    ->options(['Pending'=>'Pending', 'Processed'=>'Processed'])//Completed
                    ->label('Status'),
                Forms\Components\RichEditor::make('reason')
                    ->label('Reason')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('companyEmployee.user.name')
                    ->label('Employee Name'),
                Tables\Columns\TextColumn::make('leave_days_sold')
                    ->label('Days Sold'),
                Tables\Columns\TextColumn::make('sale_amount')
                    ->label('Amount'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
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
            'index' => Pages\ListLeaveSales::route('/'),
            'create' => Pages\CreateLeaveSale::route('/create'),
            'edit' => Pages\EditLeaveSale::route('/{record}/edit'),
        ];
    }
}
