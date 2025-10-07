<?php

namespace App\Filament\Exports;

use App\Models\Company\Company;
use App\Models\Finance\Payroll;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PayrollExporter extends Exporter
{
    protected static ?string $model = Payroll::class;

    public static function getColumns(): array
    {
        /*return [
//            ExportColumn::make('company.company_name'),
//            ExportColumn::make('month'),
//                ExportColumn::make('id')
            ExportColumn::make('employee_name')
                ->state(function () { return 'Taonga kabandama'; }),

            ExportColumn::make('employee_id')
                ->state(function () { return '78912333'; }),

            ExportColumn::make('amount')
                ->state(function () { return '150000'; }),

            ExportColumn::make('manager_name')
                ->state(function (Payroll $record) {
                    return 'Mwemba Jan Sal';
                }),

            ExportColumn::make('company_code')
                ->state(function (Payroll $record) {
                    $company = Company::find($record->company_id);
                    return $company ? $company->code : '5905';
                }),

            ExportColumn::make('category')
                ->state(function (Payroll $record) {
                    return $record->category ?? 'C';
                }),
        ];
       */
        return [
            ExportColumn::make('custom_data')
                ->label('export') // Empty label to remove header
                ->state(function (Payroll $record): array {
                    // Get related data from other models
                    $company = Company::find($record->company_id);
                    //$employee = ::where('payroll_id', $record->id)->first();

                    // Custom data structure for each row
                    return [
                        'Taonga kabandama',
                        '78912333',
                        '150000',
//                        $employee ? $employee->full_name :
                            'Mwemba Jan Sal',
                        $company ? $company->code : '5905',
                        $record->category ?? 'C'
                    ];
                }),
           /* ExportColumn::make('custom_data')
                ->label('export') // Empty label to remove header
                ->state(function (Payroll $record): array {
                    // Get related data from other models
                    $company = Company::find($record->company_id);
                    //$employee = ::where('payroll_id', $record->id)->first();

                    // Custom data structure for each row
                    return [
                        'Taonga kabandama',
                        '78912333',
                        '150000',
//                        $employee ? $employee->full_name :
                        'Mwemba Jan Sal',
                        $company ? $company->code : '5905',
                        $record->category ?? 'C'
                    ];
                }),
            ExportColumn::make('custom_data')
                ->label('export') // Empty label to remove header
                ->state(function (Payroll $record): array {
                    // Get related data from other models
                    $company = Company::find($record->company_id);
                    //$employee = ::where('payroll_id', $record->id)->first();

                    // Custom data structure for each row
                    return [
                        'Taonga kabandama',
                        '78912333',
                        '150000',
//                        $employee ? $employee->full_name :
                        'Mwemba Jan Sal',
                        $company ? $company->code : '5905',
                        $record->category ?? 'C'
                    ];
                }),
            ExportColumn::make('custom_data')
                ->label('export') // Empty label to remove header
                ->state(function (Payroll $record): array {
                    // Get related data from other models
                    $company = Company::find($record->company_id);
                    //$employee = ::where('payroll_id', $record->id)->first();

                    // Custom data structure for each row
                    return [
                        'Taonga kabandama',
                        '78912333',
                        '150000',
//                        $employee ? $employee->full_name :
                        'Mwemba Jan Sal',
                        $company ? $company->code : '5905',
                        $record->category ?? 'C'
                    ];
                }),
            ExportColumn::make('custom_data')
                ->label('export') // Empty label to remove header
                ->state(function (Payroll $record): array {
                    // Get related data from other models
                    $company = Company::find($record->company_id);
                    //$employee = ::where('payroll_id', $record->id)->first();

                    // Custom data structure for each row
                    return [
                        'Taonga kabandama',
                        '78912333',
                        '150000',
//                        $employee ? $employee->full_name :
                        'Mwemba Jan Sal',
                        $company ? $company->code : '5905',
                        $record->category ?? 'C'
                    ];
                }),
            ExportColumn::make('custom_data')
                ->label('export') // Empty label to remove header
                ->state(function (Payroll $record): array {
                    // Get related data from other models
                    $company = Company::find($record->company_id);
                    //$employee = ::where('payroll_id', $record->id)->first();

                    // Custom data structure for each row
                    return [
                        'Taonga kabandama',
                        '78912333',
                        '150000',
//                        $employee ? $employee->full_name :
                        'Mwemba Jan Sal',
                        $company ? $company->code : '5905',
                        $record->category ?? 'C'
                    ];
                }),*/
        ];

    }
    public function getFormattedColumns(): array
    {
        // Override to flatten our custom array into columns
        return [
            'column_1',
            'column_2',
            'column_3',
            'column_4',
            'column_5',
            'column_6',
        ];
    }
    protected function getRecords(): array
    {
        // Custom query with eager loading
        return Payroll::with(['company', 'employee'])
            ->where('status', 'completed') // Example filter
            ->get()
            ->map(function ($record) {
                // Transform each record to include data from related models
                return [
                    'custom_data' => [
                        'Taonga kabandama',
                        $record->month,
                        $record->id,
                        $record->employee->full_name ?? 'Mwemba Jan Sal',
                        $record->company->code ?? '5905',
                        $record->category ?? 'C'
                    ]
                ];
            })
            ->toArray();
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your custom payroll export has completed with ' . number_format($export->successful_rows) . ' records.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' records failed to export.';
        }

        return $body;
    }

    // Optional: Customize file name
    public function getFileName(Export $export): string
    {
        return 'custom-payroll-export-' . now()->format('Y-m-d');
    }
//
//    public static function getCompletedNotificationBody(Export $export): string
//    {
//        $body = 'Your payroll export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';
//
//        if ($failedRowsCount = $export->getFailedRowsCount()) {
//            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
//        }
//
//        return $body;
//    }
}
