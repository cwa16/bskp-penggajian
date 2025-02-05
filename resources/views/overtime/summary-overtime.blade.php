@extends('layouts.main')
@section('content')
    {{-- Bagian  Isi Konten --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ $title }}</h6>
                    </div>
                </div>

                <div class="card-body p-3 pb-2">
                    <div style="overflow: auto;">
                        {{-- <img src="{{ asset('assets/img/logo.png') }}" alt="" width="15%"
                            style="float: right; margin-left: 20px;"> --}}
                        <form action="{{ route('summary-overtime-index') }}" method="GET"
                            style="display: flex; gap: 10px; width: 60%;">
                            @csrf
                            <select name="deptInput" id="dept" class="form-control form-control-outline"
                                style="flex: 1;">
                                <option value="" selected disabled>Pilih Dept</option>
                                <option value="All Dept">All Dept</option>
                                @foreach ($getEmployeesDept as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach
                            </select>
                            <select name="status" id="status" class="form-control" style="flex: 1;">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="All Status">All Status</option>
                                @foreach ($getEmployeesStatus as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                            <input type="month" name="month" id="" class="form-control" style="flex: 1;">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>

                    <br>
                    <br>
                    <div class="table-responsive p-0">
                        <table class="table table-small table-striped table-hover dtTable2 align-items-center compact">
                            <thead>
                                <tr>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">No</th>
                                    <th style="background-color: #1A73E8;color: white;">Dept</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">NIK</th>
                                    <th style="background-color: #1A73E8;color: white;">Name</th>
                                    <th style="background-color: #1A73E8;color: white;">Jabatan</th>
                                    <th style="background-color: #1A73E8;color: white;">Status</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        Limit</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        Actual</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        after Calculation</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        from Salary</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($overtime_records as $index => $ot)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $ot->dept }}</td>
                                        <td class="text-center">{{ $ot->nik }}</td>
                                        <td>{{ $ot->name }}</td>
                                        <td>{{ $ot->jabatan }}</td>
                                        <td>{{ $ot->status }}</td>
                                        @if ($ot->overtime_limit == 0 || $ot->overtime_limit == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">{{ $ot->overtime_limit }} Jam</td>
                                        @endif

                                        @if ($ot->overtimeHourInDecimal == 0 || $ot->overtimeHourInDecimal == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">{{ number_format($ot->overtimeHourInDecimal, 2) }}
                                                Jam
                                            </td>
                                        @endif

                                        @if ($ot->overtime_hour_after_cal == 0 || $ot->overtime_hour_after_cal == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">{{ number_format($ot->overtime_hour_after_cal, 2) }}
                                                Jam
                                            </td>
                                        @endif

                                        @if ($ot->hour_call == 0 || $ot->hour_call == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">{{ $ot->hour_call }} Jam</td>
                                        @endif

                                        <td class="text-center">
                                            <form action="{{ route('summary-overtime-detail') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="nik" id=""
                                                    value="{{ $ot->nik }}">
                                                <button class="btn btn-primary btn-sm">Detail</button>
                                            </form>
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
    {{-- /Bagian  Isi Konten --}}
@endsection
