<?php

namespace App\Filament\Resources\Company;

use App\Filament\Resources\Company\CompanyEmploymentTypeResource\Pages;
use App\Filament\Resources\Company\CompanyEmploymentTypeResource\RelationManagers;
use App\Models\Company\CompanyEmploymentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CompanyEmploymentTypeResource extends Resource
{
    protected static ?string $model = CompanyEmploymentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Employer Management";
    protected static ?int $navigationSort = -802;


    public static function getEloquentQuery(): Builder
    {
        return CompanyEmploymentType::byCompany(companyId: Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type_name')
                    ->rules('min:3|max:10')
                    ->label('Employment Type')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpan(2)
                    ->required(),
                //->searchable(),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
//            ->modifyQueryUsing(function (Builder $query) {
//                if (!Auth::user()->hasRole('super_admin')) {
//                    $query->whereRaw('1=0'); // Force no results if not super admin
//                }
//            })
            ->columns([
                Tables\Columns\TextColumn::make('type_name')
                    ->label('Employment Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
//                    Tables\Columns\TextColumn::make('company.company_name')
//                    ->label('Company')
//                    ->sortable()
//                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn () => Auth::user()->hasRole('super_admin'))
                ->disabled(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->hasRole('super_admin')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyEmploymentTypes::route('/'),
            'create' => Pages\CreateCompanyEmploymentType::route('/create'),
            'edit' => Pages\EditCompanyEmploymentType::route('/{record}/edit'),
        ];
    }
}
