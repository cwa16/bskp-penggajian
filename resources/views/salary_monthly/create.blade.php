@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Input Data Gaji Per Tahun</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <form action="{{ route('salarymonthly.create') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-auto">
                                    <select name="id_status" class="form-select form-select-sm">
                                        <option value="">- Pilih Status -</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                @if ($status->id == $selectedStatus) selected @endif>{{ $status->name_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                                    <a type="button" href="{{ route('salaryannual.index') }}"
                                        class="btn btn-outline-secondary btn-sm mb-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                        @if (request()->filled('id_status') && $users->isNotEmpty())
                            <hr class="horizontal dark my-2">
                            <form action="{{ route('salarymonthly.store') }}" method="post" class="salary-annual-form">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-success btn-sm px-4">Save</button>
                                    </div>
                                    <div class="col">
                                        <div class="table-responsive p-0">
                                            <table
                                                class="table align-items-center small-tbl dtTableFix3 compact stripe hover">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" class="text-center p-0">#</th>
                                                        <th  colspan="6" class="text-center p-0">Employee
                                                            Identity</th>
                                                        <th colspan="2" class="text-center p-0">Salary Components</th>
                                                        <th  colspan="4" class="text-center p-0">
                                                            Deduction</th>
                                                    </tr>
                                                    <tr class="">
                                                        <th class="cell-border">NIK</th>
                                                        <th>Name</th>
                                                        <th>Grade</th>
                                                        <th>Status</th>
                                                        <th>Dept</th>
                                                        <th>Job</th>
                                                        <th>Rate Salary</th>
                                                        <th>Total Overtime</th>
                                                        <th>Union</th>
                                                        <th>Absent</th>
                                                        <th>Electricity</th>
                                                        <th>Koperasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $key => $user)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td class="text-nowrap text-end">{{ $user->nik }}</td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->grade->name_grade ?? '-' }}</td>
                                                            <td>{{ $user->status->name_status }}</td>
                                                            <td>{{ $user->dept->name_dept }}</td>
                                                            <td>{{ $user->job->name_job }}</td>
                                                            <td class="text-end">
                                                                @if ($user->grade && $user->grade->salary_grades->isNotEmpty())
                                                                    {{ number_format($user->grade->salary_grades->first()->rate_salary, 0, ',', '.') }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="id_user[]"
                                                                    value="{{ $user->id }}">
                                                                <input type="hidden" name="id_salary_grade[]"
                                                                    value="{{ $user->grade->salary_grades->first()->id ?? '' }}">
                                                                <input type="hidden" name="rate_salary[]"
                                                                    value="{{ $user->grade->salary_grades->first()->rate_salary ?? '' }}">

                                                                <div class="input-group input-group-outline">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 120px"
                                                                        name="total_overtime[{{ $key }}]"
                                                                        placeholder="Enter the total overtime">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-outline">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 120px"
                                                                        name="union[{{ $key }}]"
                                                                        placeholder="Enter the union">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-outline">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 120px"
                                                                        name="absent[{{ $key }}]"
                                                                        placeholder="Enter the absent">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-outline">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 120px"
                                                                        name="electricity[{{ $key }}]"
                                                                        placeholder="Enter the electricity">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-outline">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 120px"
                                                                        name="koperasi[{{ $key }}]"
                                                                        placeholder="Enter the koperasi">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endsection
