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
                                <a href="{{ url('/print-all') }}" class="btn btn-icon btn-3 btn-warning btn-sm"
                                    target="_blank">
                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                    <span class="btn-inner--text">Print All</span>
                                </a>
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
                                <thead class="bg-thead">
                                    <tr>
                                        {{-- <th rowspan="2" class="text-center">No</th> --}}
                                        <th colspan="7" class="text-center p-0">Employee Identity</th>
                                        <th colspan="11" class="text-center p-0">Salary Components</th>
                                        <th rowspan="2" class="text-center">Bruto Salary</th>
                                        <th colspan="7" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center">Total Deduction</th>
                                        <th rowspan="2" class="text-center">Nett Salary</th>
                                        <th rowspan="2" class="text-center">Date Input</th>
                                        <th rowspan="2" class="text-center">Check</th>
                                        <th rowspan="2" class="text-center">Approve</th>
                                        <th rowspan="2" class="text-center">Action</th>
                                    </tr>
                                    <tr>
                                        {{-- <th>No</th> --}}
                                        <th style="background-color: #1A73E8;color: white;">Emp Code</th>
                                        <th style="background-color: #1A73E8;color: white;">Name</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Grade</th>
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
                                        <th>Cooperative</th>
                                        <th>Sub Total Deduction</th>
                                        {{-- <th class=">Total Deduction</th> --}}
                                        {{-- <th class="bg-info text-white">Nett Salary</th> --}}
                                        {{-- <th>Tanggal Pengisian</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salary_months as $key => $sal)
                                        <tr>
                                            <td class="text-nowrap text-end">{{ $sal->salary_year->user->nik }}</td>
                                            <td><a data-bs-toggle="modal"
                                                    href="#detailGaji{{ $sal->id }}">{{ $sal->salary_year->user->name }}</a>
                                            </td>
                                            <td>{{ $sal->salary_year->user->status->name_status }}</td>
                                            <td>{{ $sal->salary_year->user->dept->name_dept }}</td>
                                            <td>{{ $sal->salary_year->user->job->name_job }}</td>
                                            <td>{{ $sal->salary_year->user->grade->name_grade }}</td>
                                            <td>-</td>
                                            <td class="text-end">
                                                {{ number_format($sal->salary_year->salary_grade->rate_salary, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ number_format($sal->ability, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->fungtional_allowance, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->family_allowance, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sal->adjustment, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->transport_allowance, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sal->total_overtime, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ number_format($sal->thr, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sal->bonus, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sal->incentive, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->gross_salary, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sal->gross_salary + $sal->salary_year->total_ben, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ number_format($sal->salary_year->bpjs, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sal->salary_year->jamsostek, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->union, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->absent, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->electricity, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->cooperative, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->total_deduction, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sal->total_deduction + $sal->salary_year->total_ben_ded, 0, ',', '.') }}
                                            </td>
                                            <td class="bg-light text-dark text-end">
                                                {{ number_format($sal->net_salary, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ date('d M Y', strtotime($sal->date)) }}</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-success"> &#10004;</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-secondary">&#9744;</td>
                                            <td class="text-center m-0 p-0">
                                                <button class="btn btn-primary btn-icon-only m-0 p-0 btn-sm" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#detailGaji{{ $sal->id }}">
                                                    <span class="btn-inner--icon"><i class="material-icons">info</i></span>
                                                </button>
                                                <a href="{{ url('/print-pdf/' . $sal->id) }}"
                                                    class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" target="_blank">
                                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                                </a>
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

        @include('salary/modaldetail')
    @endsection
