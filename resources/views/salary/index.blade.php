@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">All Salary Data</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-7">
                                <button class="btn btn-icon btn-3 btn-warning btn-sm" type="button">
                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                    <span class="btn-inner--text">Print All</span>
                                </button>
                            </div>
                            <div class="col-5 justify-content-end">
                                <form action="{{ url('/salarygrade') }}" method="GET">
                                    <div class="row">
                                        <div class="col pe-0">
                                            <select class="form-select form-select-sm " name="filter_year">
                                                <option value="all">Show All Data</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-select form-select-sm " name="filter_month">
                                                <option value="all">Show All Data</option>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table
                                class="table table-sm table-striped table-hover dtTableFix2 align-items-center small-tbl compact">
                                <thead>
                                    <tr>
                                        {{-- <th rowspan="2" class="text-center">No</th> --}}
                                        <th colspan="7" class="text-center p-0">Employee Identity</th>
                                        <th colspan="11" class="text-center p-0">Salary Components</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Bruto Salary</th>
                                        <th colspan="7" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Total Deduction</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Nett Salary</th>
                                        <th rowspan="2" class="text-center">Date Input</th>
                                        <th rowspan="2" class="text-center">Check</th>
                                        <th rowspan="2" class="text-center">Approve</th>
                                        <th rowspan="2" class="text-center">Action</th>
                                    </tr>
                                    <tr>
                                        {{-- <th>No</th> --}}
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Dept</th>
                                        <th>Status</th>
                                        <th>Grade</th>
                                        <th>Job</th>
                                        <th>No Account</th>
                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Fungtional Allowance</th>
                                        <th>Family Allowance</th>
                                        <th>Adjustment</th>
                                        <th>Transport Allowance</th>
                                        <th>Total Overtime</th>
                                        <th>THR</th>
                                        <th>Bonus</th>
                                        <th>Incentive</th>
                                        <th>Salary Gross</th>
                                        {{-- <th class=">Bruto Salary</th> --}}
                                        <th>BPJS Kesehatan</th>
                                        <th>Jamsostek</th>
                                        <th>Union</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Koperasi</th>
                                        <th>Sub Total Deduction</th>
                                        {{-- <th class=">Total Deduction</th> --}}
                                        {{-- <th class="bg-info text-white">Nett Salary</th> --}}
                                        {{-- <th>Tanggal Pengisian</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salaries as $key => $salary)
                                        <tr>
                                            <td class="text-nowrap text-end">{{ $salary->user->nik }}</td>
                                            <td><a data-bs-toggle="modal"
                                                    href="#detailGaji{{ $salary->id }}">{{ $salary->user->name }}</a></td>
                                            <td>{{ $salary->user->grade->name_grade }}</td>
                                            <td>{{ $salary->user->status->name_status }}</td>
                                            <td>{{ $salary->user->dept->name_dept }}</td>
                                            <td>{{ $salary->user->job->name_job }}</td>
                                            <td>-</td>
                                            <td class="text-end">
                                                {{ number_format($salary->salary_grade->rate_salary, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($salary->ability, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($salary->fungtional_allowance, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($salary->family_allowance, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($salary->adjustment, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($salary->transport_allowance, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($salary->total_overtime, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ number_format($salary->thr, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($salary->bonus, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($salary->incentive, 0, ',', '.') }}</td>
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
                                                        $salary->incentive,
                                                    0,
                                                    ',',
                                                    '.',
                                                ) }}
                                            </td>
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
                                                        $salary->total_benefit,
                                                    0,
                                                    ',',
                                                    '.',
                                                ) }}
                                            </td>
                                            <td class="text-end">{{ number_format($salary->bpjs, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($salary->jamsostek, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($salary->salary_grade->union, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($salary->salary_grade->absent, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($salary->salary_grade->electricity, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($salary->salary_grade->koperasi, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format(
                                                    $salary->bpjs + $salary->jamsostek + $salary->union + $salary->absent + $salary->electricity + $salary->koperasi,
                                                    0,
                                                    ',',
                                                    '.',
                                                ) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format(
                                                    $salary->bpjs +
                                                        $salary->jamsostek +
                                                        $salary->union +
                                                        $salary->absent +
                                                        $salary->electricity +
                                                        $salary->koperasi +
                                                        $salary->total_debenefit,
                                                    0,
                                                    ',',
                                                    '.',
                                                ) }}
                                            </td>
                                            <td class="bg-light text-dark text-end">
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
                                                ) }}
                                            </td>
                                            <td class="text-end">{{ date('Y-M-d', strtotime($salary->created_at)) }}</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-success"> &#10004;</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-secondary">&#9744;</td>
                                            <td class="text-center m-0 p-0">
                                                <button class="btn btn-primary btn-icon-only m-0 p-0 btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#detailGaji{{ $salary->id }}">
                                                    <span class="btn-inner--icon"><i class="material-icons">info</i></span>
                                                </button>
                                                <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($salaries as $key => $salary)
            <div class="modal fade" id="detailGaji{{ $salary->id }}" tabindex="-1" role="dialog"
                aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Data Gaji</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
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
                            </div>
                            <div class="row">
                                <div class="col">
                                    <u>Kalimantan Selatan - 70852</u>
                                </div>
                                <div class="col">
                                    Salary Payment {{ date('F Y', strtotime($salary->created_at)) }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <table>
                                        <tr>
                                            <td>Employe Code</td>
                                            <td>: {{ $salary->user->nik }}</td>
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
                                    <table>
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
                                            <td>: {{ $salary->user->start_working }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax Number</td>
                                            <td>: -</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <table>
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
                                        <tr>
                                            <hr>
                                        </tr>
                                        <tr>
                                            <td><b>Salary Gross</b></td>
                                            <td>
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
                                                ) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col">
                                    <table>
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
                                        <tr>
                                            <td><b>Sub Total</b></td>
                                            <td>:
                                                {{ number_format($salary->jamsostek_jkk_ben + $salary->jamsostek_tk_ben + $salary->jamsostek_tht_ben + $salary->pph21_ben, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
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
                                        <tr>
                                            <td><b>Sub Total</b></td>
                                            <td>:
                                                {{ number_format($salary->jamsostek_jkk_deb + $salary->jamsostek_tk_deb + $salary->jamsostek_tht_deb + $salary->pph21_deb, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col">
                                    <table>
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
                                        <tr>
                                            <hr>
                                        </tr>
                                        <tr>
                                            <td><b>Sub Total</b></td>
                                            <td>
                                                {{ number_format(
                                                    $salary->bpjs + $salary->jamsostek + $salary->union + $salary->absent + $salary->electricity + $salary->koperasi,
                                                    0,
                                                    ',',
                                                    '.',
                                                ) }}
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td>Salary Gross + Total Benefit</td>
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
                                        <tr>
                                            <hr>
                                        </tr>
                                        <tr>
                                            <td><b>Nett Salary</b></td>
                                            <td>
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
                                                ) }}
                                            </td>
                                        </tr>
                                    </table>
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
    @endsection
