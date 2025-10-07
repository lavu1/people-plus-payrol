<?php

namespace App\Filament\Resources\Company;

use App\Filament\Resources\Company\DepartmentResource\Pages;
use App\Filament\Resources\Company\DepartmentResource\RelationManagers;
use App\Models\Company\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Employer Management";
    protected static ?int $navigationSort = -802;



    public static function getEloquentQuery(): Builder
    {
        $companyId = Auth::user()->current_company_id; // Get the current user's company ID

        return Department::byCompany($companyId);
    }


    public static function getPermissions(): array
    {
        return [
            'create_company_department',

        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_branch_id')
                ->label('Company Branch')
                //->relationship('companyBranch', 'company_branch_name') // Assuming the field `country` exists in `countries`
                    ->relationship('companyBranch', 'company_branch_name', function ($query) {
                        if (!Auth::user()->hasRole('super_admin')) {
                            $query->where('company_id', Auth::user()->current_company_id);
                        }
                    })
                ->required()
                ->searchable()
                ->preload(25),

                Forms\Components\TextInput::make('department_name')
                    ->label('Department Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department_name')
                    ->label('Department Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('companyBranch.company_branch_name')
                    ->label('Branch')
                    ->sortable()
                    ->searchable()])
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
