@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Salary data per grade</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-8">
                                <a href="{{ url('/salarygrade/create') }}" class="btn btn-info btn-sm">Input Data</a>
                                <a href="{{ url('/salarygrade/create') }}" class="btn btn-warning btn-sm">Edit Data</a>
                            </div>
                            <div class="col-4 justify-content-end">
                                <form action="{{ url('/salarygrade') }}" method="GET">
                                    <div class="row">
                                        <div class="col">
                                            <select class="form-select form-select-sm " name="filter_year">
                                                <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>
                                                    Show All Data</option>
                                                @foreach ($years as $year)
                                                    <option value="{{ $year }}"
                                                        {{ $selectedYear == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
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
                            <table class="table table-sm align-items-center dtTable small-tbl compact stripe">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Grade</th>
                                        {{-- <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th> --}}
                                        <th>Rate Salary</th>
                                        <th>Year</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salary_grades as $key => $sg)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $sg->grade->name_grade }}</td>
                                            {{-- <td>Monthly</td>
                                            <td>BSKP</td>
                                            <td>Operator</td> --}}
                                            <td class="text-end">{{ $sg->rate_salary }}</td>
                                            <td class="text-end">{{ $sg->year }}</td>
                                            <td class="text-center m-0 p-0">
                                                <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                    <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                                </button>
                                                {{-- <button class="btn btn-danger btn-icon-only m-0 p-0 btn-sm" type="button">
                                                    <span class="btn-inner--icon"><i
                                                            class="material-icons">delete</i></span>
                                                </button> --}}
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
    @endsection
