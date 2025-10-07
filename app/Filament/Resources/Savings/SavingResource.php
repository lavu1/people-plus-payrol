<?php

namespace App\Filament\Resources\Savings;

use App\Models\Company\CompanyEmployee;
use App\Models\Finance\Saving;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SavingResource extends Resource
{
    protected static ?string $model = Saving::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Deductions, Benefits & Tax Management";
    protected static ?int $navigationSort = -400;


    public static function getEloquentQuery(): Builder
    {
        return Saving::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('company_employee_id')
                    ->options(function () {
                        $query = CompanyEmployee::query();

                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->whereHas('department.companyBranch', function ($query) {
                                $query->where('company_id', Auth::user()->current_company_id);
                            });
                        }

                        return $query->with('user')->get()->pluck('user.name', 'id');
                    })
                    ->label('Employee')
                    ->required(),
                TextInput::make('total_savings')
                    ->label('Total Savings')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('companyEmployee.user.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_savings')
                    ->label('Total Savings')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
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
            'index' => \App\Filament\Resources\Savings\SavingResource\Pages\ListSavings::route('/'),
            'create' => \App\Filament\Resources\Savings\SavingResource\Pages\CreateSaving::route('/create'),
            'edit' => \App\Filament\Resources\Savings\SavingResource\Pages\EditSaving::route('/{record}/edit'),
        ];
    }
}
