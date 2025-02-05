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
        <h1 style="margin-top: -10px;">MANAGER SALARY PAYMENT <span
                style="text-transform: uppercase">{{ $dateMng }}</span>
        </h1>
    </div>
    <div class="content">
        <h3>Manager</h3>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th colspan="{{ $employeeIdentityColsMng }}">Employee Identity</th>
                    <th colspan="{{ $salaryComponentColsMng }}">Salary Component</th>
                    <th rowspan="2">Bruto<br>Salary</th>
                    <th colspan="{{ $deductionColsMng }}">Deduction</th>
                    <th rowspan="2">Net<br>Salary</th>
                </tr>

                <tr>
                    @foreach ($displayColumnsMng as $columnMng)
                        @if ($columnMng !== 'net_salary' && $columnMng !== 'bruto_salary')
                            <th>{{ ucwords(str_replace('_', ' ', $columnMng)) }}</th>
                        @endif
                    @endforeach
                </tr>

            </thead>

            <tbody>
                @foreach ($salariesMng as $index => $salaryMng)
                    <tr>
                        <td width="5px" style="text-align: center">{{ $index + 1 }}</td>
                        @foreach ($displayColumnsMng as $columnMng)
                            @if ($columnMng == 'Emp Code')
                                <td width="33px" style="text-align: center">
                                    {{ ucwords(str_replace('_', ' ', $salaryMng->$columnMng)) }}</td>
                            @elseif ($columnMng == 'Nama')
                                <td width="110px"
                                    style="text-align: left; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                    {{ ucwords(str_replace('_', ' ', $salaryMng->$columnMng)) }}</td>
                            @elseif ($columnMng == 'Grade')
                                <td width="30px" style="text-align: center">
                                    {{ ucwords(str_replace('_', ' ', $salaryMng->$columnMng)) }}</td>
                            @elseif (
                                $columnMng == 'rate_salary' ||
                                    $columnMng == 'ability' ||
                                    $columnMng == 'family_alw' ||
                                    $columnMng == 'transport_alw' ||
                                    $columnMng == 'skill_alw' ||
                                    $columnMng == 'telephone_alw' ||
                                    $columnMng == 'total_overtime' ||
                                    $columnMng == 'incentive' ||
                                    $columnMng == 'adjustment' ||
                                    $columnMng == 'gross_salary' ||
                                    $columnMng == 'fungtional_alw' ||
                                    $columnMng == 'thr' ||
                                    $columnMng == 'bonus')
                                @if ($salaryMng->$columnMng == 0 || $salaryMng->$columnMng == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryMng->$columnMng, 0, ',', '.') }}</td>
                                @endif
                            @elseif ($columnMng == 'bruto_salary')
                                @if ($salaryMng->$columnMng == 0 || $salaryMng->$columnMng == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryMng->$columnMng, 0, ',', '.') }}</td>
                                @endif
                            @elseif (
                                $columnMng == 'pinjaman' ||
                                    $columnMng == 'bpjs' ||
                                    $columnMng == 'jamsostek' ||
                                    $columnMng == 'union' ||
                                    $columnMng == 'absent' ||
                                    $columnMng == 'electricity' ||
                                    $columnMng == 'cooperative' ||
                                    $columnMng == 'total_deduction' ||
                                    $columnMng == 'absent' ||
                                    $columnMng == 'other')
                                @if ($salaryMng->$columnMng == 0 || $salaryMng->$columnMng == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryMng->$columnMng, 0, ',', '.') }}</td>
                                @endif
                            @elseif ($columnMng == 'net_salary')
                                @if ($salaryMng->$columnMng == 0 || $salaryMng->$columnMng == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryMng->$columnMng, 0, ',', '.') }}</td>
                                @endif
                            @else
                                <td>{{ $salaryMng->$columnMng }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

            <tfoot style="font-weight: bold">
                <tr>
                    <td colspan="4" style="text-align: center;">Total</td>
                    @foreach ($displayColumnsMng as $columnMng)
                        @if ($columnMng == 'rate_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalRateSalaryMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'ability')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAbilityMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'fungtional_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalFungtionalAlwMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'skill_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalSkillAlwMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'family_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalFamilyAlwMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'telephone_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTelephoneAlwMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'transport_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTransportAlwMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'total_overtime')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTotalOTMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'incentive')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalIncentiveMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'adjustment')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAdjustmentMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'gross_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalGrossSalaryMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'bruto_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBrutoSalaryMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'thr')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalThrMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'bonus')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBonusMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'pinjaman')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalPinjamanMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'bpjs')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBpjsMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'jamsostek')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalJamsostekMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'union')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalUnionMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'other')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalOtherMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'absent')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAbsentMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'electricity')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalElectricityMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'cooperative')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalCooperativeMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'total_deduction')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTotalDedMng, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnMng == 'net_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalNetSalaryMng, 0, ',', '.') }}</td>
                        @endif
                    @endforeach
                </tr>
            </tfoot>
        </table>

        <br>

        <h3>Staff</h3>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th colspan="{{ $employeeIdentityColsStaff }}">Employee Identity</th>
                    <th colspan="{{ $salaryComponentColsStaff }}">Salary Component</th>
                    <th rowspan="2">Bruto<br>Salary</th>
                    <th colspan="{{ $deductionColsStaff }}">Deduction</th>
                    <th rowspan="2">Net<br>Salary</th>
                </tr>

                <tr>
                    @foreach ($displayColumnsStaff as $columnStaff)
                        @if ($columnStaff !== 'net_salary' && $columnStaff !== 'bruto_salary')
                            <th>{{ ucwords(str_replace('_', ' ', $columnStaff)) }}</th>
                        @endif
                    @endforeach
                </tr>

            </thead>

            <tbody>
                @foreach ($salariesStaff as $index => $salaryStaff)
                    <tr>
                        <td width="5px" style="text-align: center">{{ $index + 1 }}</td>
                        @foreach ($displayColumnsStaff as $columnStaff)
                            @if ($columnStaff == 'Emp Code')
                                <td width="33px" style="text-align: center">
                                    {{ ucwords(str_replace('_', ' ', $salaryStaff->$columnStaff)) }}</td>
                            @elseif ($columnStaff == 'Nama')
                                <td width="110px"
                                    style="text-align: left; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                    {{ ucwords(str_replace('_', ' ', $salaryStaff->$columnStaff)) }}</td>
                            @elseif ($columnStaff == 'Grade')
                                <td width="30px" style="text-align: center">
                                    {{ ucwords(str_replace('_', ' ', $salaryStaff->$columnStaff)) }}</td>
                            @elseif (
                                $columnStaff == 'rate_salary' ||
                                    $columnStaff == 'ability' ||
                                    $columnStaff == 'family_alw' ||
                                    $columnStaff == 'transport_alw' ||
                                    $columnStaff == 'skill_alw' ||
                                    $columnStaff == 'telephone_alw' ||
                                    $columnStaff == 'total_overtime' ||
                                    $columnStaff == 'incentive' ||
                                    $columnStaff == 'adjustment' ||
                                    $columnStaff == 'gross_salary' ||
                                    $columnStaff == 'fungtional_alw' ||
                                    $columnStaff == 'thr' ||
                                    $columnStaff == 'bonus')
                                @if ($salaryStaff->$columnStaff == 0 || $salaryStaff->$columnStaff == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryStaff->$columnStaff, 0, ',', '.') }}</td>
                                @endif
                            @elseif ($columnStaff == 'bruto_salary')
                                @if ($salaryStaff->$columnStaff == 0 || $salaryStaff->$columnStaff == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryStaff->$columnStaff, 0, ',', '.') }}</td>
                                @endif
                            @elseif (
                                $columnStaff == 'pinjaman' ||
                                    $columnStaff == 'bpjs' ||
                                    $columnStaff == 'jamsostek' ||
                                    $columnStaff == 'union' ||
                                    $columnStaff == 'absent' ||
                                    $columnStaff == 'electricity' ||
                                    $columnStaff == 'cooperative' ||
                                    $columnStaff == 'total_deduction' ||
                                    $columnStaff == 'absent' ||
                                    $columnStaff == 'other')
                                @if ($salaryStaff->$columnStaff == 0 || $salaryStaff->$columnStaff == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryStaff->$columnStaff, 0, ',', '.') }}</td>
                                @endif
                            @elseif ($columnStaff == 'net_salary')
                                @if ($salaryStaff->$columnStaff == 0 || $salaryStaff->$columnStaff == null)
                                    <td width="35px" style="text-align: right">-</td>
                                @else
                                    <td width="35px"
                                        style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                        {{ number_format($salaryStaff->$columnStaff, 0, ',', '.') }}</td>
                                @endif
                            @else
                                <td>{{ $salaryStaff->$columnStaff }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

            <tfoot style="font-weight: bold">
                <tr>
                    <td colspan="4" style="text-align: center;">Total</td>
                    @foreach ($displayColumnsStaff as $columnStaff)
                        @if ($columnStaff == 'rate_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalRateSalaryStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'ability')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAbilityStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'fungtional_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalFungtionalAlwStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'skill_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalSkillAlwStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'family_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalFamilyAlwStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'telephone_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTelephoneAlwStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'transport_alw')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTransportAlwStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'total_overtime')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTotalOTStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'incentive')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalIncentiveStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'adjustment')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAdjustmentStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'gross_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalGrossSalaryStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'bruto_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBrutoSalaryStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'thr')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalThrStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'bonus')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBonusStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'pinjaman')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalPinjamanStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'bpjs')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalBpjsStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'jamsostek')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalJamsostekStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'union')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalUnionStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'other')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalOtherStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'absent')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalAbsentStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'electricity')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalElectricityStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'cooperative')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalCooperativeStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'total_deduction')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalTotalDedStaff, 0, ',', '.') }}</td>
                        @endif

                        @if ($columnStaff == 'net_salary')
                            <td
                                style="text-align: right; padding-top: 4px; padding-bottom: 1px; padding-left: 3px; padding-right: 1px">
                                {{ number_format($totalNetSalaryStaff, 0, ',', '.') }}</td>
                        @endif
                    @endforeach
                </tr>
            </tfoot>
        </table>

        <table
            style="width: 79%; margin: 0 auto; text-align: center; border: none; border-collapse: collapse; padding-top: 30px">
            <thead>
                <tr style="text-align: center; border: none;">
                    <th colspan="7" style="border: none; padding-bottom: 50px;">Checked by</th>
                    <th style="border: none; padding-bottom: 50px;">Approved by</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border: none;">
                    <td style="border: none;">
                        <u>WIDYA CITRA MUSTIKASARI</u>
                        <br> HR Asst
                    </td>
                    <td style="border: none;">
                        <u>EMAN ISTANTO</u>
                        <br> ACC FIN Asst
                    </td>
                    <td style="border: none;">
                        <u>JOHARI</u>
                        <br> HR GA Mng
                    </td>
                    <td style="border: none;">
                        <u>HENDY PRASSONANTIO</u>
                        <br> ACC FIN Mng
                    </td>
                    <td style="border: none;">
                        <u>SURYANI</u>
                        <br> Director
                    </td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none;">
                        <u>TSUNEHISA SAKODA</u>
                        <br> President Director
                    </td>
                </tr>
            </tbody>
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
