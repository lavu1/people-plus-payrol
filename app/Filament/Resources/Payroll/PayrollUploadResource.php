<?php

namespace App\Filament\Resources\Payroll;

use App\Filament\Imports\Payroll\PayrollImporter;
use App\Filament\Resources\Payroll\PayrollUploadResource\Pages;
use App\Models\Finance\PayrollUpload;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PayrollUploadResource extends Resource
{
    protected static ?string $model = PayrollUpload::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Payroll Processing";
    protected static ?int $navigationSort = -300;

    public static function getEloquentQuery(): Builder
    {
        return PayrollUpload::byCompany(Auth::user()->current_company_id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pension_percentage'),
                TextInput::make('pension_percentage')
                    ->label('Pension Percentage')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                Forms\Components\FileUpload::make('upload_file_path')
                    ->directory('payroll-attachments')
                    ->label('Company')
                    ->required(),
                TextInput::make('employee_name')
                    ->required()
                    ->label('Employee Name'),
                TextInput::make('employee_number')
                    ->required()
                    ->label('Employee Number'),
                TextInput::make('bank_details')
                    ->label('Bank Details'),
                TextInput::make('mobile_money_phone_number')
                    ->label('Mobile Money Phone Number'),
                TextInput::make('social_security_number')
                    ->label('Social Security Number'),
                TextInput::make('tpin')
                    ->label('TPIN'),
                DatePicker::make('date_of_birth')
                    ->required()
                    ->label('Date of Birth'),
                TextInput::make('email')
                    ->email()
                    ->label('Email'),
                TextInput::make('basic_pay')
                    ->numeric()
                    ->label('Basic Pay'),
                Select::make('pay_type')
                    ->options([
                        'hourly' => 'Hourly',
                        'salary' => 'Salary',
                    ])
                    ->label('Pay Type'),
                TextInput::make('leave_days_taken')
                    ->numeric()
                    ->label('Leave Days Taken'),
                TextInput::make('overtime_hours_payable')
                    ->numeric()
                    ->label('Overtime Hours Payable'),
                TextInput::make('allowance_name')
                    ->label('Allowance Name'),
                TextInput::make('allowance_amount')
                    ->numeric()
                    ->label('Allowance Amount'),
//                Forms\Components\FileUpload::make('upload_file_path')
//                    ->directory('payroll-attachments')
//                    ->label('Company')
//                    ->required(),
                Forms\Components\Checkbox::make('status')
                    ->label('Status')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_name')->label('Employee Name'),
                TextColumn::make('employee_number')->label('Employee Number'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('basic_pay')->label('Basic Pay'),
                TextColumn::make('pay_type')->label('Pay Type'),
                TextColumn::make('leave_days_taken')->label('Leave Days Taken'),
                TextColumn::make('overtime_hours_payable')->label('Overtime Hours Payable'),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\CheckboxColumn::make('status')
                    ->label('Status')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()->importer(PayrollImporter::class)
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
            'index' => Pages\ListPayrollUploads::route('/'),
            'create' => Pages\CreatePayrollUpload::route('/create'),
            'edit' => Pages\EditPayrollUpload::route('/{record}/edit'),
        ];
    }
}
