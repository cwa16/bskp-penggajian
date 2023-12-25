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
                                <a href="{{ url('/salary-year/create') }}" class="btn btn-info btn-sm">Input Data</a>
                                <a href="{{ url('/salary-year/edit') }}" class="btn btn-warning btn-sm">Edit Data</a>
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
                                <thead class="bg-thead">
                                    <tr>
                                        <th colspan="6" class="text-center p-0">Employee Identity</th>
                                        <th colspan="6" class="text-center p-0">Salary Components</th>
                                        <th colspan="2" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center">Year</th>
                                        {{-- <th rowspan="2" class="text-center">Action</th> --}}
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8;color: white;">NIK</th>
                                        <th style="background-color: #1A73E8;color: white;">Name</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Grade</th>
                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Fungtional Allowance</th>
                                        <th>Family Allowance</th>
                                        <th>Transport Allowance</th>
                                        <th>Adjustment</th>
                                        <th>BPJS Kesehatan</th>
                                        <th>Jamsostek</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salary_years as $key => $sy)
                                        <tr>
                                            <td class="text-nowrap text-end">{{ $sy->user->nik }}</td>
                                            <td>{{ $sy->user->name }}</td>
                                            <td>{{ $sy->user->status->name_status }}</td>
                                            <td>{{ $sy->user->dept->name_dept }}</td>
                                            <td>{{ $sy->user->job->name_job }}</td>
                                            <td>{{ $sy->user->grade->name_grade }}</td>
                                            <td class="text-end">
                                                {{ number_format($sy->salary_grade->rate_salary, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sy->ability, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sy->fungtional_alw, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sy->family_alw, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sy->transport_alw, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sy->adjustment, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sy->bpjs, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sy->jamsostek, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ $sy->year }}</td>
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
