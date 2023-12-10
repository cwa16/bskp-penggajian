@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Salary Data Per Year</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-7">
                                <a href="{{ url('/salaryannual/create') }}" class="btn btn-info btn-sm">Input Data</a>
                                <a href="{{ url('/salaryannual/edit') }}" class="btn btn-warning btn-sm">Edit Data</a>
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
                                            <select class="form-select form-select-sm " name="filter_year">
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
                            <table class="table table-sm dtTableFix2 align-items-center small-tbl compact stripe hover"
                                style="font-size: 10pt; font-family: 'Arial', sans-serif;">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center p-0">Employee Identity</th>
                                        <th colspan="6" class="text-center p-0">Salary Components</th>
                                        <th colspan="2" class="text-center p-0">Deduction</th>
                                        {{-- <th rowspan="2" class="text-center">Action</th> --}}
                                    </tr>
                                    <tr class="">
                                        <th class="cell-border">NIK</th>
                                        <th>Name</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Fungtional Allowance</th>
                                        <th>Family Allowance</th>
                                        <th>Adjustment</th>
                                        <th>Transport Allowance</th>
                                        <th>BPJS</th>
                                        <th>Jamsostek</th>
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
                                            <td class="text-end">{{ number_format($salary->bpjs, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($salary->jamsostek, 0, ',', '.') }}</td>
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
