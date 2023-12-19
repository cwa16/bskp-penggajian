<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAL_{{ date('My', strtotime($salary->created_at)) }}_{{ $salary->user->nik }}_{{ $salary->user->name }}
    </title>


    <!-- CSS Files -->
    {{-- <link id="pagestyle" href="{{ public_path ('assets/libs/bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
        }

        .tb-detail {
            border-collapse: collapse;
            width: 100%;
            font-size: 9pt;
        }

        .tb-detail th,
        .tb-detail td {
            border: none;
            width: auto;
        }

        .right-border {
            border-top: 1px solid #000;
        }

        .left-border {
            border-top: 1px solid #000;
        }

        .buttom-border {
            border-top: 1px solid #000;
        }

        .top-border {
            border-top: 1px solid #000;
        }

        .dash-line {
            border: none;
            border-top: 2px dashed #888;
        }

        .table-collapse table,
        th,
        td {
            width: 100%;
            border: 1px none #000;
            border-collapse: collapse;
        }

        .outline-border {
            border: 1px solid black;
            padding: 8px;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="table-collapse">
        <table>
            <tr>
                <td>PT BRIDGESTONE KALIMANTAN PLANTATION</td>
                <td></td>
            </tr>
            <tr>
                <td>Bentok Darat, Bati-Bati, Kab.Tanah Laut</td>
                <td align="right" class="uppercase">SALARY PAYMENT {{ date('F Y', strtotime($salary->created_at)) }}</td>
            </tr>
            <tr>
                <td> <u>Kalimantan Selatan - 70852</u></td>
                <td></td>
            </tr>
        </table>
    </div>

    <hr class="dash-line">

    <div class="table-collapse">
        <table>
            <tr>

                <td>
                    <table class="tb-detail">
                        <tr>
                            <td>Employe Code </td>
                            <td> : {{ $salary->user->nik }}</td>
                        </tr>
                        <tr>
                            <td>Employe Name</td>
                            <td>: {{ $salary->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Grade</td>
                            <td>: {{ $salary->user->grade->name_grade }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: {{ $salary->user->status->name_status }}</td>
                        </tr>
                    </table>
                </td>

                <td>
                    <table class="tb-detail">
                        <tr>
                            <td>Departement</td>
                            <td>: {{ $salary->user->dept->name_dept }}</td>
                        </tr>
                        <tr>
                            <td>Job</td>
                            <td>: {{ $salary->user->job->name_job }}</td>
                        </tr>
                        <tr>
                            <td>Start working</td>
                            <td>: {{ date('H:i', strtotime($salary->user->start_work_user)) }}</td>
                        </tr>
                        <tr>
                            <td>Tax Number</td>
                            <td>: -</td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>
    </div>

    <hr class="dash-line">

    <div class="table-collapse">
        <table>
            <tr>

                <td rowspan="2" style="vertical-align: top; padding-right: 10px;  padding-bottom: 0;">
                    <table class="tb-detail">
                        <tr>
                            <td colspan="3"><u><b>A. SALARY COMPONENT</b></u></td>
                        </tr>
                        <tr>
                            <td>Grade</td>
                            <td>:</td>
                            <td class="text-end">
                                {{ number_format($salary->salary_grade->rate_salary, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Ability</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->ability, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Fungtional Allowance</td>
                            <td>:</td>
                            <td class="text-end">
                                {{ number_format($salary->fungtional_allowance, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Family Allowance</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->family_allowance, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Adjustment</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->adjustment, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Transport Allowance</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->transport_allowance, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Total Overtime</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->total_overtime, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>THR</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->thr, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Bonus</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->bonus, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Incentive</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->incentive, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="top-border">
                            <td><b>Salary Gross</b></td>
                            <td>:</td>
                            <td class="text-end"><b>
                                    {{ number_format(
                                        $salary->salary_grade->rate_salary +
                                            $salary->ability +
                                            $salary->fungtional_allowance +
                                            $salary->family_allowance +
                                            $salary->adjustment +
                                            $salary->transport_allowance +
                                            $salary->total_overtime +
                                            $salary->thr +
                                            $salary->bonus +
                                            $salary->incentive,
                                        0,
                                        ',',
                                        '.',
                                    ) }}</b>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="padding-left: 10px; padding-right: 10px;">
                    <table class="tb-detail">
                        <tr>
                            <td colspan="3"><u><b>B. DEDUCTION</b></u></td>
                        </tr>
                        <tr>
                            <td>BPJS</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->bpjs, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Jamsostek</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->jamsostek, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Union</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->union, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Absent</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->absent, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Electricity</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->electricity, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Koperasi</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->koperasi, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="top-border">
                            <td><b>Sub Total</b></td>
                            <td>:</td>
                            <td class="text-end"><b>
                                    {{ number_format(
                                        $salary->bpjs + $salary->jamsostek + $salary->union + $salary->absent + $salary->electricity + $salary->koperasi,
                                        0,
                                        ',',
                                        '.',
                                    ) }}</b>
                            </td>
                        </tr>
                    </table>
                </td>

                <td rowspan="2" style="vertical-align: top; padding-left:10px; padding-bottom: 0;">
                    <table class="tb-detail">
                        <tr>
                            <td colspan="3"><u><b>C. BENEFIT</b></u></td>
                        </tr>
                        <tr>
                            <td>Jamsostek JKK</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->jamsostek_jkk_ben, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jamsostek TK</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->jamsostek_tk_ben, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jamsostek THT</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->jamsostek_tht_ben, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tax PPh 21</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->pph21_ben, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="top-border">
                            <td><b>Sub Total</b></td>
                            <td>:</td>
                            <td class="text-end"><b>
                                    {{ number_format($salary->jamsostek_jkk_ben + $salary->jamsostek_tk_ben + $salary->jamsostek_tht_ben + $salary->pph21_ben, 0, ',', '.') }}</b>
                            </td>
                        </tr>
                    </table>
                    <table class="tb-detail" style="margin-top: 28px;">
                        <tr>
                            <td colspan="3"><u><b>D. DEDUCTION BENEFIT</b></u></td>
                        </tr>
                        <tr>
                            <td>Jamsostek JKK</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->jamsostek_jkk_deb, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jamsostek TK</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->jamsostek_tk_deb, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jamsostek THT</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->jamsostek_tht_deb, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tax PPh 21</td>
                            <td>:</td>
                            <td class="text-end">{{ number_format($salary->pph21_deb, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="top-border">
                            <td><b>Sub Total</b></td>
                            <td><b>:</b></td>
                            <td class="text-end"><b>
                                    {{ number_format($salary->jamsostek_jkk_deb + $salary->jamsostek_tk_deb + $salary->jamsostek_tht_deb + $salary->pph21_deb, 0, ',', '.') }}</b>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>

            <tr>

                <td style="padding-left: 10px; padding-right: 10px; margin-bottom: 0;">
                    <div class="outline-border">
                        <table class="tb-detail">
                            <tr>
                                <td>Salary Gross + <br>Total Benefit</td>
                                <td>:</td>
                                <td class="text-end">
                                    {{ number_format(
                                        $salary->salary_grade->rate_salary +
                                            $salary->ability +
                                            $salary->fungtional_allowance +
                                            $salary->family_allowance +
                                            $salary->adjustment +
                                            $salary->transport_allowance +
                                            $salary->total_overtime +
                                            $salary->thr +
                                            $salary->bonus +
                                            $salary->incentive +
                                            $salary->jamsostek_jkk_ben +
                                            $salary->jamsostek_tk_ben +
                                            $salary->jamsostek_tht_ben +
                                            $salary->pph21_ben,
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Total Deduction</td>
                                <td>:</td>
                                <td class="text-end">
                                    {{ number_format(
                                        $salary->bpjs +
                                            $salary->jamsostek +
                                            $salary->union +
                                            $salary->absent +
                                            $salary->electricity +
                                            $salary->koperasi +
                                            $salary->jamsostek_jkk_deb +
                                            $salary->jamsostek_tk_deb +
                                            $salary->jamsostek_tht_deb +
                                            $salary->pph21_deb,
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                </td>
                            </tr>
                            <tr class="top-border">
                                <td><b>Nett Salary</b></td>
                                <td>:</td>
                                <td class="text-end"><b>
                                        {{ number_format(
                                            $salary->salary_grade->rate_salary +
                                                $salary->ability +
                                                $salary->fungtional_allowance +
                                                $salary->family_allowance +
                                                $salary->adjustment +
                                                $salary->transport_allowance +
                                                $salary->total_overtime +
                                                $salary->thr +
                                                $salary->bonus +
                                                $salary->incentive +
                                                $salary->total_benefit -
                                                ($salary->bpjs +
                                                    $salary->jamsostek +
                                                    $salary->union +
                                                    $salary->absent +
                                                    $salary->electricity +
                                                    $salary->koperasi +
                                                    $salary->total_debenefit),
                                            0,
                                            ',',
                                            '.',
                                        ) }}</b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

            </tr>
        </table>

        <hr class="dash-line" style="margin-top: 0px">

        <div class="table-collapse">
            <table>
                <tr>
                    <td>
                        Receive by
                        <br><br><br>
                        {{ $salary->user->name }}
                    </td>
                    <td style="vertical-align: top">generate by system - no signature is required</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
