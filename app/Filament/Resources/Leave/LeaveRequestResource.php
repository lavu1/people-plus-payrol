<?php

namespace App\Filament\Resources\Leave;

use App\Filament\Resources\Leave\LeaveRequestResource\Pages;
use App\Filament\Resources\Leave\LeaveRequestResource\RelationManagers;
use App\Models\Company\CompanyEmployee;
use App\Models\Leave\LeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Attendance & Leave Management";
    protected static ?int $navigationSort = -500;

    public static function getEloquentQuery(): Builder
    {
        return LeaveRequest::byCompany(Auth::user()->current_company_id);
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
                Forms\Components\Select::make('leave_type_id')
                    ->label('Leave Type')
                    ->relationship('leaveType', 'leave_type_name')
                    ->required()
                    ->searchable(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('End Date')
                    ->required(),
                Forms\Components\MarkdownEditor::make('reason')
                    ->label('Reason')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(['Pending'=>'Pending', 'Approved'=>'Approved', 'Rejected'=>'Rejected', 'Cancelled'=>'Cancelled'])
                    ->label('Status')
                    ->disabled(function ($get, $record) {
                        // Only disable the input if a record exists (i.e., on edit, not create)
                        return $record && $record->status === 'Approved';
                    }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('companyEmployee.user.name')
                    ->label('Employee Name'),
                Tables\Columns\TextColumn::make('leaveType.leave_type_name')
                    ->label('Leave Type'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date'),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End date'),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Reason'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
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
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
