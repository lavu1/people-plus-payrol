<?php

namespace App\Filament\Resources\OverTime;

use App\Filament\Resources\OverTime\OverTimeClaimResource\Pages;
use App\Filament\Resources\OverTime\OverTimeClaimResource\RelationManagers;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\OverTimeClaim;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OverTimeClaimResource extends Resource
{
    protected static ?string $model = OverTimeClaim::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Attendance & Leave Management";
    protected static ?int $navigationSort = -500;

    public static function getEloquentQuery(): Builder
    {
        return OverTimeClaim::byCompany(Auth::user()->current_company_id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('actual_hours')
                    ->required()
                    ->numeric(),
//                Forms\Components\TextInput::make('computed_cost')
//                    ->required()
//                    ->numeric(),
                Forms\Components\TextInput::make('adjusted_hours')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('final_hours')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('over_time_requests_id')
                    ->relationship('overtTimeRequest', 'over_time_type')
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
                    ->required(),
//                Forms\Components\Select::make('payroll_id')
//                    ->relationship('payroll', 'month')
//                    ->required(),
//                Forms\Components\Select::make('company_employee_id')
//                   // ->relationship('companyEmployee.user', 'name')
//                   ->relationship('companyEmployee.user', 'name', function ($query) {
//                       if (!Auth::user()->hasRole('super_admin')) {
//                           $query->whereHas('company', function ($branchQuery) {
//                               $branchQuery->where('id', Auth::user()->current_company_id);
//                           });
//                       }
//                   })
//                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payroll.month')
                    ->label('Payroll Month')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('final_hours'),
                Tables\Columns\TextColumn::make('overtTimeRequest.over_time_type')
                    ->label('Overtime Request ID'),
                Tables\Columns\TextColumn::make('companyEmployee.user.name')
                    ->label('Company Employee ID'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListOverTimeClaims::route('/'),
            'create' => Pages\CreateOverTimeClaim::route('/create'),
            'edit' => Pages\EditOverTimeClaim::route('/{record}/edit'),
        ];
    }
}
