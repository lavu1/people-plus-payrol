<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 20px;
        color: #2d3748;
        font-size: 12px;
    }

    .payslip {
        margin-bottom: 25px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        page-break-inside: avoid;
    }

    .header {
        text-align: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #3b82f6;
    }

    .logo {
        max-width: 80px;
        margin-bottom: 10px;
    }

    .employee-info {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 15px;
        padding: 10px;
        background: #f8fafc;
        border-radius: 6px;
    }

    .info-item strong {
        display: block;
        color: #64748b;
        font-size: 10px;
    }

    .columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 15px;
    }

    .earnings-table, .deductions-table {
        width: 100%;
        border-collapse: collapse;
    }

    .earnings-table th, .deductions-table th {
        background-color: #3b82f6;
        color: white;
        padding: 8px;
        font-size: 10px;
        text-align: left;
    }

    .earnings-table td, .deductions-table td {
        padding: 8px;
        border-bottom: 1px solid #e2e8f0;
    }

    .total-row {
        background-color: #eff6ff;
        font-weight: bold;
    }

    .summary {
        margin-top: 15px;
        padding: 10px;
        background: #f1f5f9;
        border-radius: 6px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .net-pay {
        color: #1d4ed8;
        font-weight: bold;
        font-size: 14px;
    }

    .currency {
        font-weight: bold;
        color: #3b82f6;
    }
</style>

<body>
<div class="header">
    <img src="{{ storage_path('app/public/' . $payroll->company->logo_url) }}" class="logo">
    <div style="font-size: 14px; font-weight: bold;">{{ $payroll->company->company_name }}</div>
    <div style="font-size: 10px; color: #64748b;">Payroll Period: {{ $payroll->month }}</div>
</div>

@foreach($payroll->transactions as $transaction)
    <div class="payslip">
        <div class="employee-info">
            <div class="info-item">
                <strong>Employee Name</strong>
                {{ $transaction->companyEmployee->user->name }}
            </div>
            <div class="info-item">
                <strong>Employee ID</strong>
                {{ $transaction->companyEmployee->employee_identification_number }}
            </div>
            <div class="info-item">
                <strong>Position</strong>
                {{ $transaction->companyEmployee->position->position_name }}
            </div>
            <div class="info-item">
                <strong>Department</strong>
                {{ $transaction->companyEmployee->department->department_name }}
            </div>
        </div>

        <div class="columns">
            <table class="earnings-table">
                <thead>
                <tr>
                    <th>Earnings</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td><span class="currency">{{ $transaction->companyEmployee->currency->symbol }}</span>
                        {{ number_format($transaction->gross_salary, 2) }}</td>
                </tr>
                @foreach($transaction->companyEmployee->employeeAllowances as $allowance)
                    <tr>
                        <td>{{ $allowance->allowance_name }}</td>
                        <td><span class="currency">{{ $transaction->companyEmployee->currency->symbol }}</span>
                            {{ number_format($allowance->value, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td>Total Earnings</td>
                    <td><span class="currency">{{ $transaction->companyEmployee->currency->symbol }}</span>
                        {{ number_format($transaction->gross_salary + $transaction->allowances, 2) }}</td>
                </tr>
                </tbody>
            </table>

            <table class="deductions-table">
                <thead>
                <tr>
                    <th>Deductions</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payroll->employeedeductions as $deductions)
                    <tr>
                        <td>{{ $deductions->deduction->name }}</td>
                        <td><span class="currency">{{ $transaction->companyEmployee->currency->symbol }}</span>
                            {{ number_format($deductions->amount, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td>Total Deductions</td>
                    <td><span class="currency">{{ $transaction->companyEmployee->currency->symbol }}</span>
                        {{ number_format($transaction->deductions, 2) }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="summary">
            <div>
                <strong>Payment Method</strong><br>
                {{ $transaction->companyEmployee->paymentMethod->payment_method_name }}
            </div>
            <div>
                <strong>Currency</strong><br>
                {{ $transaction->companyEmployee->currency->currency_code }}
            </div>
            <div>
                <strong>Net Pay</strong><br>
                <span class="net-pay">
                {{ $transaction->companyEmployee->currency->symbol }}
                    {{ number_format($transaction->net_salary, 2) }}
            </span>
            </div>
        </div>
    </div>
    <div style="page-break-after: always;"></div>
@endforeach
</body>
