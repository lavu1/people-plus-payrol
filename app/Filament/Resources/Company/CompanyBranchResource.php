<?php

namespace App\Filament\Resources\Company;

use App\Filament\Resources\Company\CompanyBranchResource\Pages;
use App\Models\Company\Company;
use App\Models\Company\CompanyBranch;
use App\Models\Residency\Country;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CompanyBranchResource extends Resource
{
    protected static ?string $model = CompanyBranch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = "Employer Management";
    protected static ?int $navigationSort = -804;


    public static function getEloquentQuery(): Builder
    {
        return CompanyBranch::byCompany(companyId: Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('company_branch_name')
                    ->label('Branch Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('company_branch_code')
                    ->label('Branch Code')
                    ->required()
                    ->maxLength(50),

                Forms\Components\TextInput::make('company_branch_email')
                    ->label('Branch Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('company_branch_address')
                    ->label('Branch Address')
                    ->required(),

                   // Country dropdown
                   Forms\Components\Select::make('country_id')
                   ->label('Country')
                   ->options(Country::pluck('country', 'id')) // Get all countries
                   ->reactive() // Reload form when country is changed
                   ->afterStateUpdated(fn (callable $set) => $set('province_id', null))->columnSpan(2),

               // Province dropdown (filtered by country)
               Forms\Components\Select::make('province_id')
                   ->label('Province')
                   ->options(function (callable $get) {
                       $countryId = $get('country_id');
                       return $countryId ? Province::where('country_id', $countryId)->pluck('province_name', 'id') : [];
                   })
                   ->reactive() // Reload form when province is changed
                   ->afterStateUpdated(fn (callable $set) => $set('town_id', null))
                   ->required(),

               // Town dropdown (filtered by province)
               Forms\Components\Select::make('town_id')
                   ->label('Town')
                   ->options(function (callable $get) {
                       $provinceId = $get('province_id');
                       return $provinceId ? Town::where('province_id', $provinceId)->pluck('town_name', 'id') : [];
                   })
                   ->required()
                   ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_branch_name')
                    ->label('Branch Name')
                    ->sortable()
                    ->searchable(),

//                Tables\Columns\TextColumn::make('company_branch_code')
//                    ->label('Branch Code')
//                    ->sortable()
//                    ->searchable(),
//
//                Tables\Columns\TextColumn::make('company_branch_email')
//                    ->label('Branch Email')
//                    ->sortable()
//                    ->searchable(),

                Tables\Columns\TextColumn::make('company_branch_address')
                    ->label('Branch Address')
                    ->searchable(),

//                Tables\Columns\TextColumn::make('town.province.country.country')
//                    ->label('Country')
//                    ->sortable()
//                    ->searchable(),
//
//                Tables\Columns\TextColumn::make('town.province.province_name')
//                    ->label('Province')
//                    ->sortable()
//                    ->searchable(),

                Tables\Columns\TextColumn::make('town.town_name')
                    ->label('Town')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('company.company_name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Add any filters you need
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            // Add any relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyBranches::route('/'),
            'create' => Pages\CreateCompanyBranch::route('/create'),
            'edit' => Pages\EditCompanyBranch::route('/{record}/edit'),
        ];
    }
}
