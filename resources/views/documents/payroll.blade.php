<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 40px;
        color: #2d3748;
        background-color: #f8f9fa;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        padding: 25px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-radius: 12px;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .logo {
        max-width: 120px;
        margin-bottom: 15px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .company-info {
        font-size: 0.9em;
        margin-top: 10px;
        opacity: 0.9;
    }

    .employee-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        page-break-inside: avoid;
    }

    .employee-info {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e2e8f0;
    }

    .employee-info h3 {
        color: #1d4ed8;
        margin-bottom: 15px;
        font-size: 1.4em;
    }

    .section {
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    th {
        background-color: #3b82f6;
        color: white;
        padding: 12px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85em;
        letter-spacing: 0.5px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:nth-child(even) {
        background-color: #f8fafc;
    }

    .total {
        background-color: #eff6ff;
        font-weight: 600;
    }

    .total td {
        border-top: 2px solid #3b82f6;
        border-bottom: none;
    }

    .signature {
        margin-top: 30px;
        padding-top: 15px;
        border-top: 2px solid #3b82f6;
        width: 250px;
        text-align: center;
        color: #64748b;
        font-size: 0.9em;
    }

    .payment-method {
        background: #f1f5f9;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .net-pay {
        font-size: 1.2em;
        color: #1d4ed8;
        font-weight: 700;
    }

    .currency-symbol {
        font-weight: 600;
        color: #3b82f6;
    }

    .section-title {
        color: #1e3a8a;
        font-size: 1.2em;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #3b82f6;
        display: inline-block;
    }
</style>

<body>
<div class="header">
{{--    <img src="{{ storage_path('app/public/' . $payroll->company->logo_url) }}" class="logo">--}}
    <h1>{{ $payroll->company->company_name }}</h1>
    <div class="company-info">
        {{ $payroll->company->address }}<br>
        {{ $payroll->company->phone }} | {{ $payroll->company->email }}
    </div>
    <h2>Payroll Statement for {{ $payroll->month }}</h2>
</div>

@foreach($payroll->transactions as $transaction)
    <div class="employee-section">
        <div class="employee-info">
            <h3>{{ $transaction->companyEmployee->user->name }}</h3>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <strong>Position:</strong> {{ $transaction->companyEmployee->position->position_name }}<br>
                    <strong>Department:</strong> {{ $transaction->companyEmployee->department->department_name }}
                </div>
                <div>
                    <strong>Employee ID:</strong> {{ $transaction->companyEmployee->employee_identification_number }}<br>
                    <strong>Currency:</strong> {{ $transaction->companyEmployee->currency->currency_code }}
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Earnings Breakdown</div>
            <table>
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td>
                        <span class="currency-symbol">{{ $transaction->companyEmployee->currency->symbol }}</span>
                        {{ number_format($transaction->gross_salary, 2) }}
                    </td>
                </tr>
                @foreach($transaction->companyEmployee->employeeAllowances as $allowance)
                    <tr>

                        <td>{{ $allowance->allowance->allowance_name }}</td>
                        <td>
                            <span class="currency-symbol">{{ $transaction->companyEmployee->currency->symbol }}</span>
                            {{ number_format($allowance->allowance->value, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td>Total Earnings</td>
                    <td class="net-pay">
                        <span class="currency-symbol">{{ $transaction->companyEmployee->currency->symbol }}</span>
                        {{ number_format($transaction->gross_salary + $transaction->allowances, 2) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Deductions</div>
            <table>
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payroll->employeedeductions as $deductions)
                    <tr>
                        <td>{{ $deductions->deduction->name }}</td>
                        <td>
                            <span class="currency-symbol">{{ $transaction->companyEmployee->currency->symbol }}</span>
                            {{ number_format($deductions->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td>Total Deductions</td>
                    <td>
                        <span class="currency-symbol">{{ $transaction->companyEmployee->currency->symbol }}</span>
                        {{ number_format($transaction->deductions, 2) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Payment Summary</div>
            <div class="payment-method">
                <table>
                    <tr class="total">
                        <td>Net Pay</td>
                        <td class="net-pay">
                            <span class="currency-symbol">{{ $transaction->companyEmployee->currency->symbol }}</span>
                            {{ number_format($transaction->net_salary, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td style="color: #3b82f6; font-weight: 500;">
                            {{ $transaction->companyEmployee->paymentMethod->payment_method_name }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="signature">Authorized Signature</div>
        </div>
    </div>
    <div style="page-break-after: always;"></div>
@endforeach
</body>
