@foreach ($salaries as $key => $salary)
    <div class="modal fade" id="detailGaji{{ $salary->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Gaji</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <style>
                    .tb-detail {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    .tb-detail th,
                    .tb-detail td {
                        border: none;
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
                        border-top: 3px dashed #888;
                    }
                </style>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            PT BRIDGESTONE KALIMANTAN PLANTATION
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Bentok Darat, Bati-Bati, Kab.Tanah Laut
                        </div>
                        <div class="col d-flex text-uppercase justify-content-end">
                            SALARY PAYMENT {{ date('F Y', strtotime($salary->created_at)) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <u>Kalimantan Selatan - 70852</u>
                        </div>
                    </div>
                    <hr class="dash-line">
                    <div class="row">
                        <div class="col">
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
                        </div>
                        <div class="col">
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
                        </div>
                    </div>
                    <hr class="dash-line">
                    <div class="row">
                        <div class="col">
                            <table class="tb-detail">
                                <tr>
                                    <td colspan="2"><u><b>A. SALARY COMPONENT</b></u></td>
                                </tr>
                                <tr>
                                    <td>Grade</td>
                                    <td>: {{ number_format($salary->salary_grade->rate_salary, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Ability</td>
                                    <td>: {{ number_format($salary->ability, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Fungtional Allowance</td>
                                    <td>: {{ number_format($salary->fungtional_allowance, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Family Allowance</td>
                                    <td>: {{ number_format($salary->family_allowance, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Adjustment</td>
                                    <td>: {{ number_format($salary->adjustment, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Transport Allowance</td>
                                    <td>: {{ number_format($salary->transport_allowance, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Total Overtime</td>
                                    <td>: {{ number_format($salary->total_overtime, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>THR</td>
                                    <td>: {{ number_format($salary->thr, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Bonus</td>
                                    <td>: {{ number_format($salary->bonus, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Incentive</td>
                                    <td>: {{ number_format($salary->incentive, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="top-border">
                                    <td><b>Salary Gross</b></td>
                                    <td><b>:
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
                        </div>
                        <div class="col">
                            <table class="tb-detail">
                                <tr>
                                    <td colspan="2"><u><b>B. BENEFIT</b></u></td>
                                </tr>
                                <tr>
                                    <td>Jamsostek JKK</td>
                                    <td>: {{ number_format($salary->jamsostek_jkk_ben, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Jamsostek TK</td>
                                    <td>: {{ number_format($salary->jamsostek_tk_ben, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Jamsostek THT</td>
                                    <td>: {{ number_format($salary->jamsostek_tht_ben, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Tax PPh 21</td>
                                    <td>: {{ number_format($salary->pph21_ben, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="top-border">
                                    <td><b>Sub Total</b></td>
                                    <td><b>:
                                            {{ number_format($salary->jamsostek_jkk_ben + $salary->jamsostek_tk_ben + $salary->jamsostek_tht_ben + $salary->pph21_ben, 0, ',', '.') }}</b>
                                    </td>
                                </tr>
                            </table>
                            <table class="tb-detail">
                                <tr>
                                    <td colspan="2"><u><b>C. DEDUCTION BENEFIT</b></u></td>
                                </tr>
                                <tr>
                                    <td>Jamsostek JKK</td>
                                    <td>: {{ number_format($salary->jamsostek_jkk_deb, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Jamsostek TK</td>
                                    <td>: {{ number_format($salary->jamsostek_tk_deb, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Jamsostek THT</td>
                                    <td>: {{ number_format($salary->jamsostek_tht_deb, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Tax PPh 21</td>
                                    <td>: {{ number_format($salary->pph21_deb, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="top-border">
                                    <td><b>Sub Total</b></td>
                                    <td><b>:
                                            {{ number_format($salary->jamsostek_jkk_deb + $salary->jamsostek_tk_deb + $salary->jamsostek_tht_deb + $salary->pph21_deb, 0, ',', '.') }}</b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col">
                            <table class="tb-detail">
                                <tr>
                                    <td colspan="2"><u><b>D. DEDUCTION</b></u></td>
                                </tr>
                                <tr>
                                    <td>BPJS</td>
                                    <td>: {{ number_format($salary->bpjs, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Jamsostek</td>
                                    <td>: {{ number_format($salary->jamsostek, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Union</td>
                                    <td>: {{ number_format($salary->union, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Absent</td>
                                    <td>: {{ number_format($salary->absent, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Electricity</td>
                                    <td>: {{ number_format($salary->electricity, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Koperasi</td>
                                    <td>: {{ number_format($salary->koperasi, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="top-border">
                                    <td><b>Sub Total</b></td>
                                    <td><b>:
                                            {{ number_format(
                                                $salary->bpjs + $salary->jamsostek + $salary->union + $salary->absent + $salary->electricity + $salary->koperasi,
                                                0,
                                                ',',
                                                '.',
                                            ) }}</b>
                                    </td>
                                </tr>
                            </table>
                            <div class="border border-dark p-2">
                                <table class="tb-detail">
                                    <tr>
                                        <td>Salary Gross + <br>Total Benefit</td>
                                        <td>:
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
                                        <td>:
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
                                        <td><b>:
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-icon btn-3 btn-warning btn-sm" type="button">
                        <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                        <span class="btn-inner--text">Print</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
