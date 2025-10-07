<?php

namespace App\Filament\Resources\Company;

use App\Filament\Resources\Company\CompanyEmployeeResource\Pages;
use App\Filament\Resources\Company\CompanyEmployeeResource\RelationManagers;
use App\Models\Bank\Bank;
use App\Models\Bank\BankBranch;
use App\Models\Company\Company;
use App\Models\Company\CompanyEmployee;
use App\Models\Company\Contact;
use App\Models\Company\Identification;
use App\Models\Company\NextOfKin;
use App\Models\Company\Position;
use App\Models\Finance\EmployeeBankAccount;
use App\Models\Finance\SalaryGrade;
use App\Models\Residency\Province;
use App\Models\Residency\Town;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyEmployeeResource extends Resource
{
    protected static ?string $model = CompanyEmployee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Employee Information";
    protected static ?int $navigationSort = -700;




    public static function getEloquentQuery(): Builder
    {
        $companyId = Auth::user()->current_company_id;
        return CompanyEmployee::byCompany($companyId);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([

                    Forms\Components\Wizard\Step::make('Personal Details')
                        ->schema([
                            Forms\Components\TextInput::make('user.name')
                                ->label('Full Name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Enter full name')
                                ->formatStateUsing(function ($record) {
                                    if ($record) return $record->user->name;
                                }),

                            Forms\Components\DatePicker::make('date_of_birth')
                                ->label('Date of Birth')
                                ->required()
                                ->placeholder('Select date of birth'),

                            Forms\Components\Select::make('gender')
                                ->label('Gender')
                                ->options([
                                    'male' => 'Male',
                                    'female' => 'Female',
                                    'other' => 'Other'
                                ])->formatStateUsing(function ($record) {
                                    if ($record) return $record->user->gender;
                                })
                                ->required()
                                ->columnSpan(1),

                            Forms\Components\Select::make('marital_status')
                                ->label('Marital Status')
                                ->options([
                                    'single' => 'Single',
                                    'married' => 'Married',
                                    'divorced' => 'Divorced',
                                    'widowed' => 'Widowed',
                                ])
                                ->required()
                                ->formatStateUsing(function ($record) {
                                    if ($record) return $record->user->marital_status;
                                })
                                ->columnSpan(1),


//                            Forms\Components\Select::make('country_id')
//                                ->label('Nationality')
//                                ->relationship('nationality', 'nationality')
//                                ->required()
//                                ->preload(5)
//                                ->searchable()
//                                ->columnSpan(1),

                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->helperText('This will be used to create a user account.')
                                ->visible(fn($livewire) => $livewire instanceof \App\Filament\Resources\Company\CompanyEmployeeResource\Pages\CreateCompanyEmployee)
                                ->columnSpan(1),
                        ])
                        ->columns(1),

                    Forms\Components\Wizard\Step::make('Employee Data')
                        ->schema([
//                            Forms\Components\Select::make('company_branch_id')
//                                ->label('Company Branch')
//                                ->relationship('companyBranch', 'company_branch_name', function ($query) {
//                                    $query->where('company_id', Auth::user()->current_company_id); // Filter branches by the user's company
//                                })
//                                ->required()
//                                ->searchable()
//                                ->preload()
//                                ->reactive(), // Mark this field as reactive

                            Forms\Components\Select::make('department_id')
                                ->label('Department')
                                ->relationship('department', 'department_name', function ($query) {
                                    if (!Auth::user()->hasRole('super_admin')) {
                                        $query->whereHas('companyBranch', function ($branchQuery) {
                                            $branchQuery->where('company_id', Auth::user()->current_company_id);
                                        });
                                    }
                                })
//                                ->relationship('department', 'department_name', function ($query, $get) {
//                                    // Filter departments based on the selected company_branch_id
//                                    if ($get('company_branch_id')) {
//                                        $query->where('company_branch_id', $get('company_branch_id'));
//                                    }
                                //})
                                ->required()
                                ->searchable()
                                ->preload()
                                ->reactive() // Mark this field as reactive
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('position_id', null); // Reset position when department changes
                                }),


                            Forms\Components\Select::make('position_id')
                                ->label('Position')
                                ->options(function (callable $get) {
                                    $departmentId = $get('department_id');
                                    return $departmentId
                                        ? Position::where('department_id', $departmentId)
                                        ->pluck('position_name', 'id')
                                        : [];
                                })
                                ->required()
                                ->searchable()
                                ->preload(5)
                                ->reactive(),

                            Forms\Components\Select::make('company_employment_type_id')
                                ->label('Company Employment Type')
                                ->relationship('employment_type', 'type_name')
                                ->required()
                                ->searchable()
                                ->preload(),

                                Forms\Components\Select::make('salary_grade_id')
                                ->label('Salary Grade')
                                ->relationship('salary_grade', 'grade_name', function ($query) {
                                    $branchIds = auth()->user()->company->companyBranch->pluck('id'); // Get all branch IDs
                                    $query->whereIn('company_branch_id', $branchIds);
                                })
                                ->required()
                                ->searchable()
                                ->preload()
                                ->reactive(),


                            Forms\Components\TextInput::make('salary')
                                ->label('Salary')
                                ->required()
                                ->maxLength(255)
                                ->numeric() // Ensure the input is numeric
                                ->reactive()
                                ->rule(function (callable $get) {
                                    $salaryGradeId = $get('salary_grade_id');
                                    if ($salaryGradeId) {
                                        $salaryGrade = SalaryGrade::find($salaryGradeId);
                                        if ($salaryGrade) {
                                            return [
                                                'numeric',
                                                'min:' . ($salaryGrade->min_salary ?? 0),
                                                'max:' . ($salaryGrade->max_salary ?? PHP_INT_MAX),
                                            ];
                                        }
                                    }
                                    return 'numeric';
                                })
                                ->hint(function (callable $get) {
                                    $salaryGradeId = $get('salary_grade_id');
                                    if ($salaryGradeId) {
                                        $salaryGrade = SalaryGrade::find($salaryGradeId);
                                        if ($salaryGrade) {
                                            return 'Salary must be between ' . number_format($salaryGrade->min_salary) .
                                                ' and ' . number_format($salaryGrade->max_salary) . '.';
                                        }
                                    }
                                    return 'Please select a salary grade first.';
                                }),




                            Forms\Components\Select::make('payment_method_id')
                                ->label('Payment Method')
                                ->relationship('paymentMethod', 'payment_method_name')
                                ->required()
                                ->searchable(),

                            Forms\Components\Select::make('currency_id')
                                ->label('Currency')
                                ->relationship('currency', 'currency_name')
                                ->required()
                                ->searchable(),

                            Forms\Components\TextInput::make('employee_identification_number')
                                ->rules('min:3|max:30')
                                ->label('Employee Number')
                                ->required()
                                ->maxLength(255),
                        ])->columns(1),





                    Forms\Components\Wizard\Step::make('Employee Identification')
                        ->schema([
                            Forms\Components\Select::make('identification.identification_type')
                                ->label('Identification Type')
                                ->options([
                                    'NRC' => 'NRC',
                                    'Passport' => 'Passport',
                                    'Drivers License' => 'Drivers License',
                                    'ID Card' => 'ID Card',
                                    'Residence Permit' => 'Residence Permit',
                                    'Other' => 'Other',
                                ])
                                ->required()
                                ->formatStateUsing(function ($record) {

                                    if ($record) return Identification::where('id', $record->user->identification_id)->first()->value('identification_type');
                                })
                                ->searchable()
                                ->columnSpan(2),

                                Forms\Components\TextInput::make('identification.identification_number')
                                ->label('Identification Number')
                                ->maxLength(50)
                                ->columnSpan(2)
                                ->formatStateUsing(function ($record) {
                                    if ($record && $record->user) {
                                        return optional(Identification::find($record->user->identification_id))->identification_number;
                                    }
                                    return null;
                                })
                                ->rules(function ($record) {
                                    return [
                                        'unique:identifications,identification_number,' . ($record?->user?->identification_id ?? 'NULL'),
                                    ];
                                })
                                ->required(),



                                Forms\Components\FileUpload::make('identification.nrc_url')
                                ->label('NRC Document')
                                ->disk('public')
                                ->directory('identifications/nrcs')
                                ->formatStateUsing(function ($record) {
                                    if ($record && $record->user) {
                                        $nrcUrl = optional(Identification::find($record->user->identification_id))->nrc_url;
                                        return $nrcUrl ? [$nrcUrl] : []; // Ensure it returns an array
                                    }
                                    return [];
                                })
                                ->columnSpan(2),

                            Forms\Components\FileUpload::make('identification.photo_url')
                                ->label('Photo Document')
                                ->disk('public')
                                ->directory('identifications/photos')
                                ->formatStateUsing(function ($record) {
                                    if ($record && $record->user) {
                                        $photoUrl = optional(Identification::find($record->user->identification_id))->photo_url;
                                        return $photoUrl ? [$photoUrl] : []; // Ensure it returns an array
                                    }
                                    return [];
                                })
                                ->columnSpan(2),


                        ])
                        ->columns(1),


                    Forms\Components\Wizard\Step::make('Employee Bank Account')
                        ->schema([

                            Forms\Components\Select::make('bank_account.bank_id')
                                ->label('Bank')
                                ->options(Bank::all()->pluck('bank_name', 'id'))
                                ->required()
                                ->searchable()
                                //->disabled()
                                ->reactive() // Make this field reactive
                                ->formatStateUsing(function ($record) {
                                    if ($record) return EmployeeBankAccount::find($record->employee_bank_account_id)->bank->id;
                                })
                                ->columnSpan(1),

                            Forms\Components\Select::make('bank_account.bank_branch_id')
                                ->label('Bank Branch')
                                ->options(function ($get) {
                                    // Fetch bank branches dynamically based on the selected bank_id
                                    if ($bankId = $get('bank_account.bank_id')) {
                                        return BankBranch::where('bank_id', $bankId)
                                            ->pluck('branch_name', 'id'); // Return key-value pairs (id => branch_name)
                                    }

                                    return []; // Return an empty array if no bank_id is selected
                                })
                                ->required()
                                ->preload(5)
                                ->searchable()
                                ->reactive() // Make this field reactive
                                ->formatStateUsing(function ($record) {
                                    if ($record) return EmployeeBankAccount::find($record->employee_bank_account_id)->bank_branch_id;
                                })
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('bank_account.sort_code')
                                ->label('Sort code')
                                ->required()
                                ->maxLength(10)
                                ->formatStateUsing(function ($record) {
                                    if ($record) return EmployeeBankAccount::find($record->employee_bank_account_id)->sort_code;
                                })
                                ->columnSpan(1),

                                Forms\Components\TextInput::make('bank_account.bank_account_number')
                                ->rules(function ($record) {
                                    // Only apply 'unique' rule for edit scenarios and ignore the current record's ID
                                    return [
                                        'unique:employee_bank_accounts,bank_account_number,' . optional($record)->employee_bank_account_id,
                                    ];
                                })
                                ->label('Bank Account Number')
                                ->required()
                                ->maxLength(30)
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return EmployeeBankAccount::find($record->employee_bank_account_id)->bank_account_number;
                                    }
                                })
                                ->columnSpan(1),



                        ])->columns(1),


                    Forms\Components\Wizard\Step::make('Employee Next of Kin')
                        ->schema([
                            Forms\Components\TextInput::make('next_of_kin.next_of_kin_name')
                                ->rules('min:3|max:100')
                                ->label('Next of Kin Name')
                                ->required()
                                ->maxLength(100)
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return NextOfKin::find($record->user->next_of_kin_id)->next_of_kin_name;
                                    }
                                })
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('next_of_kin.next_of_kin_identification_number')
                                ->rules('min:3|max:50')
                                ->label('Identification Number')
                                ->required()
                                ->maxLength(50)
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return NextOfKin::find($record->user->next_of_kin_id)->next_of_kin_identification_number;
                                    }
                                })
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('next_of_kin.next_of_kin_phone')
                                ->rules('min:7|max:15')
                                ->label('Phone Number')
                                ->required()
                                ->maxLength(15)
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return NextOfKin::find($record->user->next_of_kin_id)->next_of_kin_phone;
                                    }
                                })
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('next_of_kin.next_of_kin_email')
                                ->email()
                                ->label('Email Address')
                                ->required()
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return NextOfKin::find($record->user->next_of_kin_id)->next_of_kin_email;
                                    }
                                })
                                ->columnSpan(1),



                            // Province Selection (only used for filtering towns)
                            Forms\Components\Select::make('province_id') // Not saved, just for filtering
                                ->label('Province')
                                ->options(Province::pluck('province_name', 'id')) // Fetch provinces
                                ->searchable()
                                ->live() // Makes it reactive
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return NextOfKin::find($record->user->next_of_kin_id)->town->province->id;
                                    }
                                })
                                ->columnSpan(1),

                            // Town Selection (only town_id is stored in the database)
                            Forms\Components\Select::make('next_of_kin.town_id')
                                ->label('Town')
                                ->options(
                                    fn(callable $get) =>
                                    Town::where('province_id', $get('province_id'))
                                        ->pluck('town_name', 'id')
                                )
                                ->searchable()
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return NextOfKin::find($record->user->next_of_kin_id)->town->id;
                                    }
                                })
                                ->columnSpan(1),

                            Forms\Components\Textarea::make('next_of_kin.next_of_kin_address')
                                ->label('Address')
                                ->required()
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return NextOfKin::find($record->user->next_of_kin_id)->next_of_kin_address;
                                    }
                                })
                                ->columnSpan(2),
                        ])
                        ->columns(2),


                    Forms\Components\Wizard\Step::make('Employee Contacts')
                        ->schema([
                            Forms\Components\TextInput::make('contacts.phone')
                                ->label('Phone Number')
                                ->required()
                                ->maxLength(15)
                                ->rules('regex:/^[0-9]{7,15}$/') // Ensure phone numbers are numeric and within range
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return Contact::find($record->user->contact_id)->phone;
                                    }
                                })
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('contacts.email')
                                ->label('Email Address')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return Contact::find($record->user->contact_id)->email;
                                    }
                                })
                                ->columnSpan(1),



                            Forms\Components\Select::make('contacts.province_id')
                                ->label('Province')
                                ->options(Province::all()->pluck('province_name', 'id'))
                                ->searchable()
                                ->live() // Makes it reactive
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return Contact::find($record->user->contact_id)->town->province->id;
                                    }
                                })
                                ->columnSpan(1),

                            Forms\Components\Select::make('contacts.town_id')
                                ->label('Town')
                                ->options(
                                    fn(callable $get) =>
                                    Town::where('province_id', $get('contacts.province_id'))
                                        ->pluck('town_name', 'id')
                                )
                                ->searchable()
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return Contact::find($record->user->contact_id)->town->id;
                                    }
                                })
                                ->columnSpan(1),

                            Forms\Components\Textarea::make('contacts.address')
                                ->label('Address')
                                ->required()
                                ->maxLength(500)
                                ->formatStateUsing(function ($record) {
                                    if ($record) {
                                        return Contact::find($record->user->contact_id)->address;
                                    }
                                })
                                ->columnSpan(2),
                        ])
                        ->columns(2),



                ]),
            ])->columns(1);
    }



    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Full Name'),
                Tables\Columns\TextColumn::make('user.gender')
                    ->label('Gender'),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_identification_number')
                    ->label('Employee Number'),

                    Tables\Columns\TextColumn::make('department.companyBranch.company.company_name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
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
            'index' => Pages\ListCompanyEmployees::route('/'),
            'create' => Pages\CreateCompanyEmployee::route('/create'),
            'edit' => Pages\EditCompanyEmployee::route('/{record}/edit'),
        ];
    }
}
