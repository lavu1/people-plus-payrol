<?php

namespace App\Filament\Resources\Payroll;

use App\Filament\Resources\Payroll;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\GratuityTransactions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class GratuityTransactionsResource extends Resource
{
    protected static ?string $model = GratuityTransactions::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Deductions, Benefits & Tax Management";
    protected static ?int $navigationSort = -400;

    public static function getEloquentQuery(): Builder
    {
        return GratuityTransactions::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Select::make('payroll_id')
//                    ->relationship('payroll', 'month')
//                    ->required(),
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
                    ->label('Payroll')
                    ->required(),
                Select::make('gratuity_id')
                   // ->relationship('gratuity', 'companyEmployee.user.name')
                   ->relationship('gratuity.companyEmployee.user', 'name', function ($query) {
                       if (!Auth::user()->hasRole('super_admin')) {
                           $query->whereHas('company', function ($branchQuery) {
                               $branchQuery->where('id', Auth::user()->current_company_id);
                           });
                       }
                   })
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->disabled(function ($get, $record) {
                        // Check if $record exists and has payroll_id
                        if ($record && $record->payroll_id) {
                            // Fetch the payroll record
                            $payroll = \App\Models\Finance\Payroll::find($record->payroll_id);

                            // Check if payroll exists and is_processed is true
                            if ($payroll && $payroll->is_processed) {
                                return true; // Disable the amount field
                            }
                        }

                        // If no payroll or payroll is not processed, enable the field
                        return false;
                    }),
//                TextInput::make('amount')
//                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyEmployee.user.name')
                    ->label('Employee Name')
                    ->sortable(),
                TextColumn::make('payroll.month')
                    ->label('Payroll Month')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->date()
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
            'index' => Payroll\GratuityTransactionsResource\Pages\ListGratuityTransactions::route('/'),
            'create' => Payroll\GratuityTransactionsResource\Pages\CreateGratuityTransactions::route('/create'),
            'edit' => Payroll\GratuityTransactionsResource\Pages\EditGratuityTransactions::route('/{record}/edit'),
        ];
    }
}
