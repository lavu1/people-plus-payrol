<?php

namespace App\Filament\Resources\Company;

use App\Filament\Resources\Company\CompanyResource\Pages;
use App\Models\Company\Company;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use App\Models\Residency\Country;
use App\Models\Industry\Sector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = "Employer Management";
    protected static ?int $navigationSort = -805;


    public static function getEloquentQuery(): Builder
    {
        return Company::byUser(userId: Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->label('Company Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                    Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('TPIN')
                    ->label('TPIN')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                Forms\Components\TextInput::make('pacra_number')
                    ->label('Pacra Number')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),


                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->columnSpan(1)
                    ->required(),

                Forms\Components\FileUpload::make('logo_url')
                    ->label('Company Logo')
                    ->image()
                    ->columnSpan(1)
//                    ->required()
                    ->directory('company-logos') // Directory to store the logo
                    ->imagePreviewHeight('100') // Set image preview height
                    ->maxSize(2048) // Max size in KB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg']),

                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required()
                    ->maxLength(20),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                // Country dropdown
                Forms\Components\Select::make('country_id')
                    ->label('Country')
                    ->options(Country::pluck('country', 'id')) // Get all countries
                    ->reactive() // Reload form when country is changed
                    ->afterStateUpdated(fn (callable $set) => $set('province_id', null)),

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
                Forms\Components\Checkbox::make('branches')
                    ->label('Has Branches')
                ->default(false),
                Forms\Components\Checkbox::make('departments')
                    ->label('Has Departments')
                ->default(false),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Company Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('town.town_name')
                    ->label('Town')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->url('company_logos')
                    ->height(50), // Set logo thumbnail height
            ])
            ->filters([
                // Add filters if needed
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
            // Define relationships if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
