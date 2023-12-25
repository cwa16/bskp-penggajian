@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Salary Data Per Month</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-7">
                                <a href="{{ url('/salary-month/create') }}" class="btn btn-info btn-sm">Input Data</a>
                                <a href="{{ url('/salary-month/edit') }}" class="btn btn-warning btn-sm">Edit Data</a>
                            </div>
                            <div class="col-5 justify-content-end">
                                <form action="{{ url('/salarygrade') }}" method="GET">
                                    <div class="row">
                                        <div class="col pe-0">
                                            <select class="form-select form-select-sm " name="filter_year">
                                                <option value="all">Show All Data</option>
                                            </select>
                                        </div>
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
                                class="table table-sm table-striped table-hover dtTableFix2 align-items-center compact small-tbl">
                                <thead class="bg-thead">
                                    <tr>
                                        <th colspan="6" class="text-center p-0">Employee Identity</th>
                                        <th colspan="7" class="text-center p-0">Salary Components
                                        </th>
                                        <th colspan="4" class="text-center p-0">
                                            Deduction</th>
                                        <th rowspan="2" class="text-center">Month / Year</th>
                                        {{-- <th rowspan="2" class="text-center">Action</th> --}}
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8;color: white;">Emp Code</th>
                                        <th style="background-color: #1A73E8;color: white;">Name</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Grade</th>
                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Hour Call</th>
                                        <th>Total Overtime</th>
                                        <th>THR</th>
                                        <th>Bonus</th>
                                        <th>Incentive</th>
                                        <th>Union</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Cooperative</th>
                                        {{-- <th>Tanggal Pengisian</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salary_months as $key => $sm)
                                        <tr>
                                            <td class="text-nowrap text-end">{{ $sm->salary_year->user->nik }}</td>
                                            <td>{{ $sm->salary_year->user->name }}</td>
                                            <td>{{ $sm->salary_year->user->status->name_status }}</td>
                                            <td>{{ $sm->salary_year->user->dept->name_dept }}</td>
                                            <td>{{ $sm->salary_year->user->job->name_job }}</td>
                                            <td>{{ $sm->salary_year->user->grade->name_grade }}</td>
                                            <td class="text-end">
                                                {{ number_format($sm->salary_year->salary_grade->rate_salary, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sm->salary_year->ability, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sm->hour_call, 0, ',', '.') }} h
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sm->total_overtime, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sm->thr, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sm->bonus, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sm->incentive, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sm->union, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sm->absent, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sm->electricity, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sm->cooperative, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ date('M/Y', strtotime($sm->date)) }}</td>
                                            {{-- <td class="text-center m-0 p-0">
                                                <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                    <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                                </button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
