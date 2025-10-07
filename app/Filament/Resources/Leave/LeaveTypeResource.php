<?php

namespace App\Filament\Resources\Leave;

use App\Filament\Resources\Leave\LeaveTypeResource\Pages;
use App\Filament\Resources\Leave\LeaveTypeResource\RelationManagers;
use App\Models\Leave\LeaveType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LeaveTypeResource extends Resource
{
    protected static ?string $model = LeaveType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Attendance & Leave Management";
    protected static ?int $navigationSort = -500;

    public static function getEloquentQuery(): Builder
    {
        return LeaveType::byCompany(Auth::user()->current_company_id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('leave_type_name')
                    ->label('Leave type')
                    ->required(),
                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->relationship('company', 'company_name')
                    ->required()
                    ->searchable()
                    ->visible(Auth::user()->roles->pluck('name')->contains('super_admin')),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('leave_type_name')
                    ->label('Leave Type'),

                Tables\Columns\TextColumn::make('company.company_name')
                    ->label('Company Name')
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
            'index' => Pages\ListLeaveTypes::route('/'),
            'create' => Pages\CreateLeaveType::route('/create'),
            'edit' => Pages\EditLeaveType::route('/{record}/edit'),
        ];
    }
}
