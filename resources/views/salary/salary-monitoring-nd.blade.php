@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Manager Table -->
                <div class="pb-1">
                    <div class="p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-1">
                            <h4 class="text-white text-capitalize ps-3">{{ $title }}</h4>
                        </div>
                    </div>
                </div>
                <div class=" my-1">
                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-8">
                                <button data-bs-toggle="modal" data-bs-target="#addKomentar"
                                    class="btn btn-info btn-sm">Tambahkan Catatan</button>
                            </div>
                            <div class="col-4 justify-content-end">
                                <form action="{{ url('/salary-monitoring') }}" method="GET">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="role" value="{{ $role }}">
                                    <input type="hidden" name="nik" value="{{ $nik }}">
                                    <input type="hidden" name="dept" value="{{ $dept }}">
                                    <input type="hidden" name="jabatan" value="{{ $jabatan }}">

                                    <div class="row">
                                        <div class="col pe-0">
                                            <select class="form-select form-select-sm" name="filter_year">
                                                <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>
                                                    Show All Year
                                                </option>
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
                            <h6 class="text-left">Position: Manager</h6>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; padding: 5px; border: 1px solid white;"
                                            class="text-center" rowspan="2" width="5px">Year</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" rowspan="2">Month</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 10px; padding-right: 10px;"
                                            class="text-center" rowspan="2">No of<br>employee</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 30px; padding-right: 30px;"
                                            class="text-center" rowspan="2">Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 20px; padding-right: 20px;"
                                            class="text-center" rowspan="2">Allowance</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px;"
                                            class="text-center" rowspan="2">Insentive<br>&<br>Overtime</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 33px; padding-right: 33px;"
                                            class="text-center" rowspan="2">Total<br>Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Average<br>per person</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" colspan="5">Check</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Approval</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR GA <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">Director</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counts as $month => $statuses)
                                        <tr>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $currentYear }}</td>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $month }}
                                            </td>
                                            <td class="text-center">{{ $statuses['Manager']['employee_count'] ?? 0 }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Manager']['total_rate_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Manager']['total_allowance'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Manager']['total_overtime_incentive'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Manager']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Manager']['average_salary'] ?? 0, 0, ',', '.') }}
                                            </td>

                                            {{-- Checked 1 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'HR Legal')
                                                    @if ($statuses['Manager']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_1"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if ($statuses['Manager']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 2 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'Acc & Fin')
                                                    @if (($statuses['Manager']['is_checked_1'] ?? false) && ($statuses['Manager']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_1'] ?? false) && !($statuses['Manager']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Manager']['is_checked_1'] ?? false) && ($statuses['Manager']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_1'] ?? false) && !($statuses['Manager']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 3 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'HR GA')
                                                    @if (($statuses['Manager']['is_checked_2'] ?? false) && ($statuses['Manager']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_2'] ?? false) && !($statuses['Manager']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Manager']['is_checked_2'] ?? false) && ($statuses['Manager']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_2'] ?? false) && !($statuses['Manager']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 4 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'Acc Fin')
                                                    @if (($statuses['Manager']['is_checked_3'] ?? false) && ($statuses['Manager']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_3'] ?? false) && !($statuses['Manager']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Manager']['is_checked_3'] ?? false) && ($statuses['Manager']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_3'] ?? false) && !($statuses['Manager']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 5 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Dir')
                                                    @if (($statuses['Manager']['is_checked_4'] ?? false) && ($statuses['Manager']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_4'] ?? false) && !($statuses['Manager']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Manager']['is_checked_4'] ?? false) && ($statuses['Manager']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_4'] ?? false) && !($statuses['Manager']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Approved  --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'PD')
                                                    @if (($statuses['Manager']['is_checked_5'] ?? false) && ($statuses['Manager']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_5'] ?? false) && !($statuses['Manager']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Manager']['is_checked_5'] ?? false) && ($statuses['Manager']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Manager']['is_checked_5'] ?? false) && !($statuses['Manager']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Manager">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h6 class="text-left">Position: Staff</h6>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; padding: 5px; border: 1px solid white;"
                                            class="text-center" rowspan="2" width="5px">Year</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" rowspan="2">Month</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 10px; padding-right: 10px;"
                                            class="text-center" rowspan="2">No of<br>employee</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 30px; padding-right: 30px;"
                                            class="text-center" rowspan="2">Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 20px; padding-right: 20px;"
                                            class="text-center" rowspan="2">Allowance</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px;"
                                            class="text-center" rowspan="2">Insentive<br>&<br>Overtime</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 33px; padding-right: 33px;"
                                            class="text-center" rowspan="2">Total<br>Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Average<br>per person</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" colspan="5">Check</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Approval</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR GA <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">Director</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counts as $month => $statuses)
                                        <tr>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $currentYear }}</td>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $month }}</td>
                                            <td class="text-center">
                                                {{ $statuses['Staff']['employee_count'] ?? 0 }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Staff']['total_rate_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Staff']['total_allowance'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Staff']['total_overtime_incentive'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Staff']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Staff']['average_salary'] ?? 0, 0, ',', '.') }}
                                            </td>

                                            {{-- Checked 1 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'HR Legal')
                                                    @if ($statuses['Staff']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_1"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if ($statuses['Staff']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 2 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'Acc & Fin')
                                                    @if (($statuses['Staff']['is_checked_1'] ?? false) && ($statuses['Staff']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_1'] ?? false) && !($statuses['Staff']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Staff']['is_checked_1'] ?? false) && ($statuses['Staff']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_1'] ?? false) && !($statuses['Staff']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 3 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'HR GA')
                                                    @if (($statuses['Staff']['is_checked_2'] ?? false) && ($statuses['Staff']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_2'] ?? false) && !($statuses['Staff']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Staff']['is_checked_2'] ?? false) && ($statuses['Staff']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_2'] ?? false) && !($statuses['Staff']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 4 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'Acc Fin')
                                                    @if (($statuses['Staff']['is_checked_3'] ?? false) && ($statuses['Staff']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_3'] ?? false) && !($statuses['Staff']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Staff']['is_checked_3'] ?? false) && ($statuses['Staff']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_3'] ?? false) && !($statuses['Staff']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 5 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Dir')
                                                    @if (($statuses['Staff']['is_checked_4'] ?? false) && ($statuses['Staff']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_4'] ?? false) && !($statuses['Staff']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Staff']['is_checked_4'] ?? false) && ($statuses['Staff']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_4'] ?? false) && !($statuses['Staff']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Approved  --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'PD')
                                                    @if (($statuses['Staff']['is_checked_5'] ?? false) && ($statuses['Staff']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_5'] ?? false) && !($statuses['Staff']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Staff']['is_checked_5'] ?? false) && ($statuses['Staff']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Staff']['is_checked_5'] ?? false) && !($statuses['Staff']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Staff">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h6 class="text-left">Position: Monthly</h6>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; padding: 5px; border: 1px solid white;"
                                            class="text-center" rowspan="2" width="5px">Year</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" rowspan="2">Month</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 10px; padding-right: 10px;"
                                            class="text-center" rowspan="2">No of<br>employee</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 30px; padding-right: 30px;"
                                            class="text-center" rowspan="2">Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 20px; padding-right: 20px;"
                                            class="text-center" rowspan="2">Allowance</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px;"
                                            class="text-center" rowspan="2">Insentive<br>&<br>Overtime</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 33px; padding-right: 33px;"
                                            class="text-center" rowspan="2">Total<br>Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Average<br>per person</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" colspan="5">Check</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Approval</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR GA <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">Director</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counts as $month => $statuses)
                                        <tr>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $currentYear }}</td>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $month }}</td>
                                            <td class="text-center">
                                                {{ $statuses['Monthly']['employee_count'] ?? 0 }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Monthly']['total_rate_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Monthly']['total_allowance'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Monthly']['total_overtime_incentive'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Monthly']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Monthly']['average_salary'] ?? 0, 0, ',', '.') }}
                                            </td>

                                            {{-- Checked 1 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'HR Legal')
                                                    @if ($statuses['Monthly']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_1"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if ($statuses['Monthly']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 2 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'Acc & Fin')
                                                    @if (($statuses['Monthly']['is_checked_1'] ?? false) && ($statuses['Monthly']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_1'] ?? false) && !($statuses['Monthly']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Monthly']['is_checked_1'] ?? false) && ($statuses['Monthly']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_1'] ?? false) && !($statuses['Monthly']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 3 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'HR GA')
                                                    @if (($statuses['Monthly']['is_checked_2'] ?? false) && ($statuses['Monthly']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_2'] ?? false) && !($statuses['Monthly']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Monthly']['is_checked_2'] ?? false) && ($statuses['Monthly']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_2'] ?? false) && !($statuses['Monthly']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 4 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'Acc Fin')
                                                    @if (($statuses['Monthly']['is_checked_3'] ?? false) && ($statuses['Monthly']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_3'] ?? false) && !($statuses['Monthly']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Monthly']['is_checked_3'] ?? false) && ($statuses['Monthly']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_3'] ?? false) && !($statuses['Monthly']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 5 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Dir')
                                                    @if (($statuses['Monthly']['is_checked_4'] ?? false) && ($statuses['Monthly']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_4'] ?? false) && !($statuses['Monthly']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Monthly']['is_checked_4'] ?? false) && ($statuses['Monthly']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_4'] ?? false) && !($statuses['Monthly']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Approved  --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'PD')
                                                    @if (($statuses['Monthly']['is_checked_5'] ?? false) && ($statuses['Monthly']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_5'] ?? false) && !($statuses['Monthly']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Monthly']['is_checked_5'] ?? false) && ($statuses['Monthly']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Monthly']['is_checked_5'] ?? false) && !($statuses['Monthly']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Monthly">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h6 class="text-left">Position: Contract BSKP</h6>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; padding: 5px; border: 1px solid white;"
                                            class="text-center" rowspan="2" width="5px">Year</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" rowspan="2">Month</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 10px; padding-right: 10px;"
                                            class="text-center" rowspan="2">No of<br>employee</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 30px; padding-right: 30px;"
                                            class="text-center" rowspan="2">Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 20px; padding-right: 20px;"
                                            class="text-center" rowspan="2">Allowance</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px;"
                                            class="text-center" rowspan="2">Insentive<br>&<br>Overtime</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 33px; padding-right: 33px;"
                                            class="text-center" rowspan="2">Total<br>Salary</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Average<br>per person</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white;"
                                            class="text-center" colspan="5">Check</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 23px; padding-right: 23px;"
                                            class="text-center" rowspan="2">Approval</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Asst</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">HR GA <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">ACC FIN <br> Mng</th>
                                        <th style="background-color: #1A73E8; color: white; font-size: 12.5px; border: 1px solid white; padding-left: 12px; padding-right: 12px;"
                                            class="text-center">Director</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counts as $month => $statuses)
                                        <tr>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $currentYear }}</td>
                                            <td class="text-center"
                                                style="padding-left: 7px; padding-right: 7px; font-size: 12.5px;">
                                                {{ $month }}</td>
                                            <td class="text-center">
                                                {{ $statuses['Contract BSKP']['employee_count'] ?? 0 }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Contract BSKP']['total_rate_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Contract BSKP']['total_allowance'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Contract BSKP']['total_overtime_incentive'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Contract BSKP']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end" style="padding: 5px; font-size: 12.5px;">
                                                {{ number_format($statuses['Contract BSKP']['average_salary'] ?? 0, 0, ',', '.') }}
                                            </td>

                                            {{-- Checked 1 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'HR Legal')
                                                    @if ($statuses['Contract BSKP']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Contract BSKP">
                                                            <input type="hidden" name="checked_1"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    @if ($statuses['Contract BSKP']['is_checked_1'] ?? false)
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 2 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Asst Mng' && $dept == 'Acc & Fin')
                                                    @if (($statuses['Contract BSKP']['is_checked_1'] ?? false) && ($statuses['Contract BSKP']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_1'] ?? false) && !($statuses['Contract BSKP']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="Contract BSKP">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Contract BSKP']['is_checked_1'] ?? false) && ($statuses['Contract BSKP']['is_checked_2'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_1'] ?? false) && !($statuses['Contract BSKP']['is_checked_2'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="checked_2"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 3 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'HR GA')
                                                    @if (($statuses['Contract BSKP']['is_checked_2'] ?? false) && ($statuses['Contract BSKP']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_2'] ?? false) && !($statuses['Contract BSKP']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Contract BSKP']['is_checked_2'] ?? false) && ($statuses['Contract BSKP']['is_checked_3'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_2'] ?? false) && !($statuses['Contract BSKP']['is_checked_3'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="checked_3"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 4 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Mng' && $dept == 'Acc Fin')
                                                    @if (($statuses['Contract BSKP']['is_checked_3'] ?? false) && ($statuses['Contract BSKP']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_3'] ?? false) && !($statuses['Contract BSKP']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Contract BSKP']['is_checked_3'] ?? false) && ($statuses['Contract BSKP']['is_checked_4'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_3'] ?? false) && !($statuses['Contract BSKP']['is_checked_4'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="checked_4"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Checked 5 --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'Dir')
                                                    @if (($statuses['Contract BSKP']['is_checked_4'] ?? false) && ($statuses['Contract BSKP']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_4'] ?? false) && !($statuses['Contract BSKP']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Contract BSKP']['is_checked_4'] ?? false) && ($statuses['Contract BSKP']['is_checked_5'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_4'] ?? false) && !($statuses['Contract BSKP']['is_checked_5'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="checked_5"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>

                                            {{-- Approved  --}}
                                            <td class="justify-content-center align-items-center">
                                                @if ($jabatan == 'PD')
                                                    @if (($statuses['Contract BSKP']['is_checked_5'] ?? false) && ($statuses['Contract BSKP']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_5'] ?? false) && !($statuses['Contract BSKP']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (($statuses['Contract BSKP']['is_checked_5'] ?? false) && ($statuses['Contract BSKP']['is_approved'] ?? false))
                                                        <div style="margin: 0;">
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </div>
                                                    @elseif (($statuses['Contract BSKP']['is_checked_5'] ?? false) && !($statuses['Contract BSKP']['is_approved'] ?? false))
                                                        <form action="{{ route('salary-monitoring-approve') }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="status"
                                                                value="Contract BSKP">
                                                            <input type="hidden" name="approved"
                                                                value="{{ $month }}">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✔
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div style="margin: 0;">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm py-1 px-2"
                                                                style="margin: 0; border-radius: 10; box-shadow: none; padding: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;"
                                                                disabled>
                                                                ✘
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
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
    </div>

    <div class="modal fade" id="addKomentar" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambahkan Catatan</h5>
                        </div>

                        <form action="{{ route('grade.store') }}" method="post" class="add_edit_grade">
                            @csrf
                            <div class="card-body py-2">
                                <div class="form-group input-group input-group-outline">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Tambahkan catatan"></textarea>
                                </div>
                            </div>
                            <div class="card-footer text-end pt-0">
                                <button type="button" class="btn btn-sm  btn-outline-secondary m-0"
                                    data-bs-dismiss="modal" onclick="resetForm('add_edit_grade')">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-success text-white m-0">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // Function to enable checkboxes dynamically
    document.addEventListener('DOMContentLoaded', function() {
        // Get all rows
        document.querySelectorAll('tbody tr').forEach(function(row) {
            // Get all checkboxes for the current row
            const checkbox1 = row.querySelector('[id^="approval1-"]');
            const checkbox2 = row.querySelector('[id^="approval2-"]');
            const checkbox3 = row.querySelector('[id^="approval3-"]');
            const checkbox4 = row.querySelector('[id^="approval4-"]');
            const checkbox5 = row.querySelector('[id^="approval5-"]');
            const checkbox6 = row.querySelector('[id^="approval6-"]');

            // Add event listener to the first checkbox
            checkbox1.addEventListener('change', function() {
                if (this.checked) {
                    checkbox2.disabled = false; // Enable second checkbox
                } else {
                    checkbox2.disabled = true;
                    checkbox3.disabled = true;
                    checkbox4.disabled = true;
                    checkbox5.disabled = true;
                    checkbox6.disabled = true;
                    checkbox2.checked = false;
                    checkbox3.checked = false;
                    checkbox4.checked = false;
                    checkbox5.checked = false;
                    checkbox6.checked = false;
                }
            });

            // Add event listener to the second checkbox
            checkbox2.addEventListener('change', function() {
                if (this.checked) {
                    checkbox3.disabled = false; // Enable third checkbox
                } else {
                    checkbox3.disabled = true;
                    checkbox4.disabled = true;
                    checkbox5.disabled = true;
                    checkbox6.disabled = true;
                    checkbox3.checked = false;
                    checkbox4.checked = false;
                    checkbox5.checked = false;
                    checkbox6.checked = false;
                }
            });

            // Add event listener to the third checkbox
            checkbox3.addEventListener('change', function() {
                if (this.checked) {
                    checkbox4.disabled = false; // Enable fourth checkbox
                } else {
                    checkbox4.disabled = true;
                    checkbox5.disabled = true;
                    checkbox6.disabled = true;
                    checkbox4.checked = false;
                    checkbox5.checked = false;
                    checkbox6.checked = false;
                }
            });

            // Add event listener to the fourth checkbox
            checkbox4.addEventListener('change', function() {
                if (this.checked) {
                    checkbox5.disabled = false; // Enable fifth checkbox
                } else {
                    checkbox5.disabled = true;
                    checkbox6.disabled = true;
                    checkbox5.checked = false;
                    checkbox6.checked = false;
                }
            });

            // Add event listener to the fifth checkbox
            checkbox5.addEventListener('change', function() {
                if (this.checked) {
                    checkbox6.disabled = false; // Enable sixth checkbox
                } else {
                    checkbox6.disabled = true;
                    checkbox6.checked = false;
                }
            });
        });
    });
</script>
