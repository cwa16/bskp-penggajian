@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h3 class="text-white text-capitalize ps-3">{{ $title }}</h3>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="table-responsive p-0">
                            <table
                                class="table table-sm table-striped table-hover dtTable100 align-items-center small-tbl compact"
                                id="example">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center"
                                            rowspan="2">Year</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center"
                                            rowspan="2">Month</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center"
                                            colspan="6">Manager
                                        </th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center"
                                            colspan="6">Assistant
                                            Manager
                                        </th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center"
                                            colspan="6">Monthly
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">No of
                                            employee</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Salary</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Allowance
                                        </th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Insentive &
                                            Overtime</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Total
                                            Salary</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Avarage per
                                            person</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">No of
                                            employee</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Salary</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Allowance
                                        </th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Insentive &
                                            Overtime</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Total
                                            Salary</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Avarage per
                                            person</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">No of
                                            employee</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Salary</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Allowance
                                        </th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Insentive &
                                            Overtime</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Total
                                            Salary</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Avarage per
                                            person</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $currentYearRowspan = $counts->count();
                                        $firstRow = true;
                                    @endphp

                                    @foreach ($counts as $month => $statuses)
                                        <tr>
                                            @if ($firstRow)
                                                <td class="text-center" rowspan="{{ $currentYearRowspan }}">
                                                    {{ $currentYear }}</td>
                                                @php $firstRow = false; @endphp
                                            @endif
                                            <td class="text-center">{{ $month }}</td>

                                            <!-- Manager Columns -->
                                            <td class="text-center">{{ $statuses['Manager']['employee_count'] ?? 0 }}</td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Manager']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Manager']['total_allowance'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Manager']['total_overtime_incentive'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Manager']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Manager']['average_salary'] ?? 0, 0, ',', '.') }}
                                            </td>

                                            <!-- Staff Columns -->
                                            <td class="text-center">{{ $statuses['Staff']['employee_count'] ?? 0 }}</td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Staff']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Staff']['total_allowance'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Staff']['total_overtime_incentive'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Staff']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Staff']['average_salary'] ?? 0, 0, ',', '.') }}
                                            </td>

                                            <!-- Monthly Columns -->
                                            <td class="text-center">{{ $statuses['Monthly']['employee_count'] ?? 0 }}</td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Monthly']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Monthly']['total_allowance'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Monthly']['total_overtime_incentive'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Monthly']['total_salary'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($statuses['Monthly']['average_salary'] ?? 0, 0, ',', '.') }}
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

        <script src="{{ asset('assets/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/tableToExcel.js') }}"></script>
        <script>
            $("#btn-d").click(function() {
                TableToExcel.convert(document.getElementById("example"), {
                    name: "All Salary Data.xlsx",
                });
            });
        </script>
    </div>
@endsection
