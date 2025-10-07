<?php

namespace App\Filament\Resources\Savings;

use App\Filament\Resources\Savings\SavingsApplicationResource\Pages;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\SavingsApplication;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SavingsApplicationResource extends Resource
{
    protected static ?string $model = SavingsApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Deductions, Benefits & Tax Management";
    protected static ?int $navigationSort = -400;

    public static function getEloquentQuery(): Builder
    {
        return SavingsApplication::byCompany(Auth::user()->current_company_id);
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
                Radio::make('s_type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->default('fixed')
                    ->label('Type')
                    ->required()
                    ->live(),

                TextInput::make('value')
                    ->label(fn (Get $get): string => $get('s_type') === 'fixed' ? 'Fixed Discount Amount' : 'Percentage Discount Amount')
                    ->numeric()
                    ->required()
                    ->rules(function (Get $get) {
                        if ($get('g_type') === 'percentage') {
                            return ['required', 'numeric', 'min:1', 'max:100'];
                        }
                        return ['required', 'numeric', 'min:0', 'max:1000'];
                    }),
//                Forms\Components\TextInput::make('amount')
//                    ->numeric()
//                    ->required()
//                    ->label('Amount'),
                Forms\Components\Textarea::make('reason')
                    ->label('Reason'),
                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('companyEmployee.user.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('s_type')->label('Type')->limit(50),
                Tables\Columns\TextColumn::make('value')->label('Amount')->sortable(),
//                Tables\Columns\TextColumn::make('reason')->label('Reason')->limit(50),
                Tables\Columns\IconColumn::make('status')->boolean()->label('Status'),
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
            'index' => Pages\ListSavingsApplications::route('/'),
            'create' => Pages\CreateSavingsApplication::route('/create'),
            'edit' => Pages\EditSavingsApplication::route('/{record}/edit'),
        ];
    }
}
