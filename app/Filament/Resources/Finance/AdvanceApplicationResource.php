<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\AdvanceApplicationResource\Pages;
use App\Filament\Resources\Finance\AdvanceApplicationResource\RelationManagers;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\AdvanceApplication;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AdvanceApplicationResource extends Resource
{
    protected static ?string $model = AdvanceApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Finance & Earning information";
    protected static ?int $navigationSort = -600;


    public static function getEloquentQuery(): Builder
    {
        return AdvanceApplication::byCompany(companyId: Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\Select::make('user_id')
//                    ->relationship('user', 'name') // Assuming `name` is a column in the `company_employees` table
//                    ->required()
//                    ->label('Employee'),
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
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->label('Amount'),
                Radio::make('g_type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->default('fixed')
                    ->label('Type')
                    ->required()
                    ->live(),
                Select::make('frequency')
                    ->options(['monthly','one-time'])
                    ->label('Frequency')
                    ->required(),
                TextInput::make('value')
                    ->label(fn (Get $get): string => $get('g_type') === 'fixed' ? 'Fixed Payback Amount' : 'Percentage Payback Amount')
                    ->numeric()
                    ->required()
                    ->rules(function (Get $get) {
                        if ($get('g_type') === 'percentage') {
                            return ['required', 'numeric', 'min:1', 'max:100'];
                        }
                        return ['required', 'numeric', 'min:0', 'max:1000'];
                    }),
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
//                TextColumn::make('user.name')
//                    ->label('Employee Name'),
                Tables\Columns\TextColumn::make('companyEmployee.user.name')
                    ->label('Company Employee'),
                TextColumn::make('reason')
                    ->label('Reason'),
                TextColumn::make('amount')
                    ->label('Amount'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label(' Status'),
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
            'index' => Pages\ListAdvanceApplications::route('/'),
            'create' => Pages\CreateAdvanceApplication::route('/create'),
            'edit' => Pages\EditAdvanceApplication::route('/{record}/edit'),
        ];
    }
}
