<?php

namespace App\Filament\Imports\Payroll;

use App\Models\Finance\PayrollUpload;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PayrollImporter extends Importer
{
    protected static ?string $model = PayrollUpload::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('employee_name')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255']), // Validates as a string

            ImportColumn::make('employee_number')
                ->requiredMapping()
                ->rules(['required', 'integer', 'unique:employees,employee_number']), // Ensures uniqueness

            ImportColumn::make('bank_details')
                ->requiredMapping()
                ->rules(['nullable', 'string', 'max:500']), // Optional with string validation

            ImportColumn::make('mobile_money_phone_number')
                ->requiredMapping()
                ->rules(['nullable', 'string', 'max:20']), // Allows optional phone numbers

            ImportColumn::make('social_security_number')
                ->requiredMapping()
                ->rules(['nullable', 'string', 'max:255']), // Optional SSN validation

            ImportColumn::make('tpin')
                ->requiredMapping()
                ->rules(['nullable', 'string', 'max:20']), // Optional tax ID validation

            ImportColumn::make('date_of_birth')
                ->requiredMapping()
                ->rules(['nullable', 'date']), // Validates as a date

            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['nullable', 'email', 'max:255']), // Optional and valid email format

            ImportColumn::make('basic_pay')
                ->requiredMapping()
                ->numeric() // Ensures numeric validation
                ->rules(['required', 'numeric', 'min:0']), // Minimum pay validation

            ImportColumn::make('pay_type')
                ->requiredMapping()
                ->rules(['nullable', 'string', 'in:hourly,salary']), // Limited to specific values

            ImportColumn::make('leave_days_taken')
                ->requiredMapping()
                ->numeric()
                ->rules(['nullable', 'integer', 'min:0']), // Validates leave days

            ImportColumn::make('overtime_hours_payable')
                ->requiredMapping()
                ->numeric()
                ->rules(['nullable', 'numeric', 'min:0']), // Validates payable overtime hours

            ImportColumn::make('allowance_name')
                ->requiredMapping()
                ->rules(['nullable', 'string', 'max:255']), // Optional allowance name

            ImportColumn::make('allowance_amount')
                ->requiredMapping()
                ->numeric()
                ->rules(['nullable', 'numeric', 'min:0']),
        ];
    }

    public function resolveRecord(): ?PayrollUpload
    {
        // return Payroll::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new PayrollUpload();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your payroll import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
