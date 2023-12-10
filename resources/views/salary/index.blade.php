@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Seluruh Gaji</h6>
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
                                        <th colspan="7" class="text-center p-0">Identitas Karyawan</th>
                                        <th colspan="11" class="text-center p-0">Salary Components</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Bruto Salary</th>
                                        <th colspan="7" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Total Deduction</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Nett Salary</th>
                                        <th rowspan="2" class="text-center">Tanggal Pengisian</th>
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
                                        <th>BPJS</th>
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
                                            <td class="text-nowrap text-end">{{ $salary->id_user }}</td>
                                            <td>{{ $salary->user->name }}</td>
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
                                            <td class="text-end">{{ date('Y-m-d', strtotime($salary->created_at)) }}</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-success"> &#10004;</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-secondary">&#9744;</td>
                                            <td class="text-center m-0 p-0">
                                                <button class="btn btn-primary btn-icon-only m-0 p-0 btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#detailGaji">
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

        <div class="modal fade" id="detailGaji" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Data Status</h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('status.store') }}" method="post">
                                @csrf
                                <div class="card-body py-0">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Nama Status</label>
                                        <input type="text" class="form-control" name="name_status" required>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-sm bg-success text-white m-0">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
