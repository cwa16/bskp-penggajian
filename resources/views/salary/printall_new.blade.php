<!DOCTYPE html>
<html>
<head>
    <title>Salary Report</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
        }

        table{
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 5pt;
            border-collapse: collapse;
            width: 100%;
        }

        th {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 5pt;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 5pt;
            border-collapse: collapse;
        }

        .tb-noborder th,
        .tb-noborder td {
            border: none;
            width: auto;
        }
    </style>
</head>
<body>
    <div class="header" style="text-align: center">
        <h1>PT BRIDGESTONE KALIMANTAN PLANTATION</h1>
        <h1>SALARY PAYMENT <span style="text-transform: uppercase">{{ $date }}</span></h1>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th colspan="3">Employee Identity</th>
                <th colspan="10">Salary Component</th>
                <th colspan="8">Deduction</th>
                <th rowspan="2">Net<br>Salary</th>
            </tr>
            <tr>
                <th style="padding-bottom: 5px;" width="35px">Emp<br>Code</th>
                <th width="90px">Name</th>
                <th width="25px">Grade</th>
                <th style="padding-bottom: 5px;">Salary<br>Grade</th>
                <th>Ability</th>
                <th>Fungtional<br>All</th>
                <th>Family<br>All</th>
                <th>Transport<br>All</th>
                <th>Skill<br>All</th>
                <th>Telephone<br>All</th>
                <th>Total<br>Overtime</th>
                <th>Incentive</th>
                <th>Salary<br>Gross</th>
                <th>BPJS</th>
                <th>Jamsostek</th>
                <th>Union</th>
                <th>Other</th>
                <th>Absent</th>
                <th>Electricity</th>
                <th>Koperasi</th>
                <th>Sub Total<br>Deduction</th>
            </tr>
        </thead>

        @php
            $rate_salary_t = 0;
            $ability_t = 0;
            $fungtional_alw_t = 0;
            $family_alw_t = 0;
            $transport_alw_t = 0;
            $telephone_alw_t = 0;
            $skill_alw_t = 0;
            $adjustment_t = 0;
            $total_overtime_t = 0;
            $thr_t = 0;
            $bonus_t = 0;
            $incentive_t = 0;
            $gross_salary_t = 0;
            $total_ben_t = 0;
            $bpjs_t = 0;
            $jamsostek_t = 0;
            $union_t = 0;
            $other_t = 0;
            $absent_t = 0;
            $electricity_t = 0;
            $cooperative_t = 0;
            $total_deduction_t = 0;
            $total_ben_ded_t = 0;
            $subtotal = 0;
        @endphp

        <tbody>
            @foreach($salaries as $index => $salary)
                <tr>
                    <td style="text-align: center" width="5px">{{ $index + 1 }}</td>
                    <td style="text-align: center">{{ $salary->nik }}</td>
                    <td>{{ $salary->name }}</td>
                    <td style="text-align: center">{{ $salary->name_grade }}</td>

                    <td style="text-align: right;">
                        {{ number_format($salary->rate_salary, 0, ',', '.') }}</td>

                    @if ($salary->ability == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->ability, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->fungtional_alw == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->fungtional_alw, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->family_alw == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->family_alw, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->transport_alw == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->transport_alw, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->skill_alw == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->skill_alw, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->telephone_alw == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->telephone_alw, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->total_overtime == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->total_overtime, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->incentive == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->incentive, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->gross_salary == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->gross_salary, 0, ',', '.')}}</td>
                    @endif

                    <td style="text-align: right;">{{ number_format($salary->bpjs, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($salary->jamsostek, 0, ',', '.') }}</td>

                    @if ($salary->union == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->union, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->other == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->other, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->absent == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->absent, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->electricity == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->electricity, 0, ',', '.')}}</td>
                    @endif

                    @if ($salary->cooperative == 0)
                        <td style="text-align: right;">-</td>
                    @else
                        <td style="text-align: right;">{{ number_format($salary->cooperative, 0, ',', '.')}}</td>
                    @endif

                    <td style="text-align: right;">{{ number_format($salary->total_deduction, 0, ',', '.') }}</td>

                    <td style="text-align: right;">{{ number_format($salary->net_salary, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
