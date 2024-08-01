<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Salary Report</title>
    <style>
        @page {
            margin: 10mm;
        }

        body {
            font-family: "Arial Narrow", Arial, sans-serif;
            font-size: 7pt;
        }

        table {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 6pt;
            border-collapse: collapse;
            width: 100%;
        }

        th {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 6.5pt;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #000;
            border-collapse: collapse;
            font-size: 6.2pt;
            border-collapse: collapse;
        }

        .content {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header" style="text-align: center; margin-top: -30px;">
        <h1>PT BRIDGESTONE KALIMANTAN PLANTATION</h1>
        <h1 style="margin-top: -10px;">SALARY PAYMENT <span style="text-transform: uppercase">{{ $date }}</span>
        </h1>
    </div>
    <div class="content">


        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th colspan="{{ $employeeIdentityCols }}">Employee Identity</th>
                    <th colspan="{{ $salaryComponentCols }}">Salary Component</th>
                    <th colspan="{{ $deductionCols }}">Deduction</th>
                    <th rowspan="2">Net<br>Salary</th>
                </tr>

                <tr>
                    @foreach ($displayColumns as $column)
                        @if ($column !== 'net_salary')
                            <th>{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($salaries as $index => $salary)
                    <tr>
                        <td width="5px" style="text-align: center">{{ $index + 1 }}</td>
                        @foreach ($displayColumns as $column)
                            @if ($column == 'Emp Code')
                                <td width="33px" style="text-align: center">
                                    {{ ucwords(str_replace('_', ' ', $salary->$column)) }}</td>
                            @elseif ($column == 'Nama')
                                <td width="110px"
                                    style="text-align: left; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                    {{ ucwords(str_replace('_', ' ', $salary->$column)) }}</td>
                            @elseif ($column == 'Grade')
                                <td width="30px" style="text-align: center">
                                    {{ ucwords(str_replace('_', ' ', $salary->$column)) }}</td>
                            @elseif (
                                $column == 'rate_salary' ||
                                    $column == 'ability' ||
                                    $column == 'family_alw' ||
                                    $column == 'transport_alw' ||
                                    $column == 'skill_alw' ||
                                    $column == 'telephone_alw' ||
                                    $column == 'total_overtime' ||
                                    $column == 'incentive' ||
                                    $column == 'fungtional_alw' ||
                                    $column == 'thr' ||
                                    $column == 'bonus')
                                @if ($salary->$column == 0 || $salary->$column == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salary->$column, 0, ',', '.') }}</td>
                                @endif
                            @elseif (
                                $column == 'pinjaman' ||
                                    $column == 'bpjs' ||
                                    $column == 'jamsostek' ||
                                    $column == 'union' ||
                                    $column == 'absent' ||
                                    $column == 'electricity' ||
                                    $column == 'cooperative' ||
                                    $column == 'total_deduction' ||
                                    $column == 'absent' ||
                                    $column == 'other')
                                @if ($salary->$column == 0 || $salary->$column == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salary->$column, 0, ',', '.') }}</td>
                                @endif
                            @elseif ($column == 'net_salary')
                                @if ($salary->$column == 0 || $salary->$column == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salary->$column, 0, ',', '.') }}</td>
                                @endif
                            @else
                                <td>{{ $salary->$column }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

            <tfoot style="font-weight: bold">
                <tr>
                    <td colspan="4" style="text-align: center;">Total</td>
                    @foreach ($displayColumns as $column)
                        @if ($column == 'rate_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalRateSalary, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'ability')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAbility, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'fungtional_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalFungtionalAlw, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'skill_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalSkillAlw, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'family_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalFamilyAlw, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'telephone_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTelephoneAlw, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'transport_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTransportAlw, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'total_overtime')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTotalOT, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'incentive')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalIncentive, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'thr')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalThr, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'bonus')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBonus, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'pinjaman')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalPinjaman, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'bpjs')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBpjs, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'jamsostek')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalJamsostek, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'union')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalUnion, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'other')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalOther, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'absent')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAbsent, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'electricity')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalElectricity, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'cooperative')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalCooperative, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'total_deduction')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTotalDed, 0, ',', '.') }}</td>
                        @endif

                        @if ($column == 'net_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalNetSalary, 0, ',', '.') }}</td>
                        @endif
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 450;
            $y = 580;
            $text = "{PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica");
            $size = 10;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>

</body>

</html>
