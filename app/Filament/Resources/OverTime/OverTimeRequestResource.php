<?php

namespace App\Filament\Resources\OverTime;

use App\Filament\Resources\OverTime\OverTimeRequestResource\Pages;
use App\Filament\Resources\OverTime\OverTimeRequestResource\RelationManagers;
use App\Models\Company\CompanyEmployee;
use App\Models\Finance\OverTimeRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OverTimeRequestResource extends Resource
{
    protected static ?string $model = OverTimeRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Attendance & Leave Management";
    protected static ?int $navigationSort = -500;


    public static function getEloquentQuery(): Builder
    {
        return OverTimeRequest::byCompany(Auth::user()->current_company_id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('over_time_type')
                    ->options(['weekend'=>'Weekends', 'holidays'=>'Holidays', 'excess_hours'=>'Excess Hours'])
                    ->required(),
                Forms\Components\TextInput::make('requested_hours')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('justification')
                    ->required(),
                Forms\Components\DatePicker::make('dates_requested')
                    ->required(),
//                Forms\Components\TextInput::make('computed_cost')
//                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('is_taxable')
                    ->label('Is Taxable')
                    ->default(false),
                Forms\Components\Textarea::make('hod_comments')
                    ->label('HOD Comments'),
                Forms\Components\Textarea::make('hr_comments')
                    ->label('HR Comments'),
                Forms\Components\Toggle::make('supervisor_triggered')
                    ->label('Supervisor Triggered')
                    ->default(false),
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
            ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('over_time_type')
                    ->label('Overtime Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('requested_hours')
                    ->label('Requested Hours')
                    ->sortable(),
                Tables\Columns\TextColumn::make('justification')
                    ->label('Justification'),
                Tables\Columns\TextColumn::make('dates_requested')
                    ->label('Dates Requested')
                    ->date(),
                Tables\Columns\TextColumn::make('computed_cost')
                    ->label('Computed Cost')
                    ->sortable(),
//                Tables\Columns\BadgeColumn::make('status')
//                    ->colors([
//                        'primary' => 'pending',
//                        'success' => 'approved',
//                        'danger' => 'rejected',
//                    ]),
//                Tables\Columns\BooleanColumn::make('is_taxable')
//                    ->label('Is Taxable'),
//                Tables\Columns\TextColumn::make('hod_comments')
//                    ->label('HOD Comments'),
//                Tables\Columns\TextColumn::make('hr_comments')
//                    ->label('HR Comments'),
//                Tables\Columns\BooleanColumn::make('supervisor_triggered')
//                    ->label('Supervisor Triggered'),
                Tables\Columns\TextColumn::make('companyEmployee.user.name')
                    ->label('Company Employee'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListOverTimeRequests::route('/'),
            'create' => Pages\CreateOverTimeRequest::route('/create'),
            'edit' => Pages\EditOverTimeRequest::route('/{record}/edit'),
        ];
    }
}
