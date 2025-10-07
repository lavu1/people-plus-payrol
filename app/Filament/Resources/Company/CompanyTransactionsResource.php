<?php

namespace App\Filament\Resources\Company;

use App\Filament\Clusters\EmployerManagement;
use App\Filament\Resources\Company\CompanyTransactionsResource\Pages;
use App\Filament\Resources\Company\CompanyTransactionsResource\RelationManagers;
use App\Models\Company\CompanyTransactions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CompanyTransactionsResource extends Resource
{
    protected static ?string $model = CompanyTransactions::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    //protected static ?string $cluster = EmployerManagement::class;
    protected static ?string $navigationGroup = "Employer Management";
    protected static ?int $navigationSort = -801;



    public static function getEloquentQuery(): Builder
    {
        return CompanyTransactions::byCompany(companyId: Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transaction_type')
                    ->options([
                        'Deposit' => 'Deposit',
                        'Withdrawal' => 'Withdrawal',
                    ])
                    ->required()
                    ->label('Transaction Type'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->label('Amount'),
                Forms\Components\TextInput::make('remarks')
                    ->required()
                    ->label('Remarks'),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'company_name', function ($query) { // Assuming the `companies` table has a `name` column
                       if (!Auth::user()->hasRole('super_admin')) {
                           $query->whereHas('companyBranch', function ($branchQuery) {
                               $branchQuery->where('company_id', Auth::user()->current_company_id);
                           });
                       }
                       })
                    ->required()
                    ->label('Company'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('transaction_type')->label('Transaction Type')->sortable(),
                Tables\Columns\TextColumn::make('amount')->label('Amount')->sortable(),
                Tables\Columns\TextColumn::make('company.company_name')->label('Company')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Updated At')->sortable(),
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
            'index' => Pages\ListCompanyTransactions::route('/'),
            'create' => Pages\CreateCompanyTransactions::route('/create'),
            'edit' => Pages\EditCompanyTransactions::route('/{record}/edit'),
        ];
    }
}
