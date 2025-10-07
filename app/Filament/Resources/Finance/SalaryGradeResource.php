<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\SalaryGradeResource\Pages;
use App\Filament\Resources\Finance\SalaryGradeResource\RelationManagers;
use App\Models\Finance\SalaryGrade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SalaryGradeResource extends Resource
{
    protected static ?string $model = SalaryGrade::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;


    public static function getEloquentQuery(): Builder
    {
        $companyId = Auth::user()->current_company_id;
        return SalaryGrade::byCompanyBranches($companyId);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('company_branch_id')
                ->label('Company Branch')
                //->relationship('companyBranch', 'company_branch_name')
                ->relationship('companyBranch', 'company_branch_name', function ($query) {
                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->where('company_id', Auth::user()->current_company_id);
                        }
                    })
                ->required()
                ->searchable()
                ->preload(),
                Forms\Components\TextInput::make('grade_name')
                    ->label('Grade Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\TextInput::make('min_salary')
                    ->label('Min salary')
                    ->required()
                    ->tel()
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\TextInput::make('max_salary')
                    ->label('Max Salary')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\TextInput::make('gratuity_percentage')
                    ->label('Gratuity Percentage')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\TextInput::make('pension_percentage')
                    ->label('Pension Percentage')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('grade_name')
                    ->label('Grade Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('min_salary')
                    ->label('Min salary')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_salary')
                    ->label('Max Salary')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gratuity_percentage')
                    ->label('Gratuity Percentage')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pension_percentage')
                    ->label('Pension Percentage')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('companyBranch.company_branch_name')
                    ->label('Branch')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('companyBranch.company.company_name')
                    ->label('Company')
                    ->sortable()
                    ->searchable()
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
            'index' => Pages\ListSalaryGrades::route('/'),
            'create' => Pages\CreateSalaryGrade::route('/create'),
            'edit' => Pages\EditSalaryGrade::route('/{record}/edit'),
        ];
    }
}
