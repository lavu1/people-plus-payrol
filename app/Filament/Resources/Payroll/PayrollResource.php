<?php

namespace App\Filament\Resources\Payroll;

use App\Filament\Exports\PayrollExporter;
use App\Filament\Resources\Payroll\PayrollResource\Pages;
use App\Models\Finance\Payroll;
use Filament\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Payroll Processing";
    protected static ?int $navigationSort = -300;

    public static function getEloquentQuery(): Builder
    {
        return Payroll::byCompany(Auth::user()->current_company_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->label('Company')
                    ->relationship('company', 'company_name')
                    ->required()
                    ->searchable()
                ->visible(Auth::user()->roles->pluck('name')->contains('super_admin')),
                TextInput::make('month')
                    ->required()
                    ->label('Month'),
//                Toggle::make('processed')
//                    ->label('Processed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.company_name')
                    ->label('Company'),
                TextColumn::make('month')
                    ->label('Month'),
                Tables\Columns\CheckboxColumn::make('processed')
                    ->label('Processed'),
//                Tables\Columns\IconColumn::make('processed')
//                    ->
//                    ->label('Processed'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ExportAction::make()
                    ->exporter(PayrollExporter::class),

                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-rectangle-stack')
                    ->url(fn (Payroll $record) => route('pdf', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('pdf')
                    ->label('Excel uba')
                    ->color('success')
                    ->icon('heroicon-o-rectangle-stack')
                    ->url(fn (Payroll $record) => route('bank-uba', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('pdf')
                    ->label('Excel Zanaco')
                    ->color('success')
                    ->icon('heroicon-o-rectangle-stack')
                    ->url(fn (Payroll $record) => route('bank-zanaco', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()->exporter(PayrollExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make(),
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}
