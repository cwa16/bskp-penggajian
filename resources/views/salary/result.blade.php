@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Annual Salary Data {{ $yearFilter }}</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-7">
                                <button class="btn btn-icon btn-3 btn-success btn-sm" id="btn-d">
                                    <span class="btn-inner--icon"><i class="fas fa-file-excel"></i></span>
                                    <span class="btn-inner--text"> Export</span>
                                </button>
                            </div>
                            <div class="col-2" style="margin-right: 800px; margin-bottom: 20px;">
                                <div class="card">
                                    <div class="card-body">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>NIK</th>
                                                    <th> : </th>
                                                    <th>{{ $name->nik }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <th> : </th>
                                                    <th>{{ $name->name }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table
                                class="table table-sm table-striped table-hover dtTable100 align-items-center small-tbl compact" id="example">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="background-color: #1A73E8;color: white;" rowspan="2" class="text-center">Year</th>
                                        <th style="background-color: #1A73E8;color: white;" rowspan="2" class="text-center">Month</th>
                                        <th colspan="5" class="text-center p-0">Employee Identity</th>
                                        <th colspan="13" class="text-center p-0">Salary Components</th>
                                        <th rowspan="2" class="text-center">Bruto Salary</th>
                                        <th colspan="7" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center">Total Deduction</th>
                                        <th rowspan="2" class="text-center">Nett Salary</th>
                                        <th rowspan="2" class="text-center">Allocation</th>
                                        <th rowspan="2" class="text-center">Date Input</th>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Grade</th>
                                        <th>No Account</th>
                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Fungtional All</th>
                                        <th>Family All</th>
                                        <th>Transport All</th>
                                        <th>Skill All</th>
                                        <th>Telephone All</th>
                                        <th>Total Overtime</th>
                                        <th>THR</th>
                                        <th>Bonus</th>
                                        <th>Incentive</th>
                                        <th>Adjustment</th>
                                        <th>Salary Gross</th>
                                        <th>BPJS Kesehatan</th>
                                        <th>Jamsostek</th>
                                        <th>Union</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Cooperative</th>
                                        <th>Sub Total Deduction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $sal)
                                        <tr>
                                            <td class="text-nowrap text-end">{{ $yearFilter }}</td>
                                            <td class="text-nowrap text-end">{{ date('F', strtotime($sal->date)) }}</td>
                                            <td>{{ $sal->name_status }}</td>
                                            <td>{{ $sal->name_dept }}</td>
                                            <td>{{ $sal->name_job }}</td>
                                            <td>{{ $sal->name_grade }}</td>
                                            <td>-</td>
                                            <td class="text-end">
                                                {{ $sal->rate_salary != 0 ? number_format($sal->rate_salary, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->ability != 0 ? number_format($sal->ability, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->fungtional_alw != 0 ? number_format($sal->fungtional_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->family_alw != 0 ? number_format($sal->family_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->transport_alw != 0 ? number_format($sal->transport_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->skill_alw != 0 ? number_format($sal->skill_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->telephone_alw != 0 ? number_format($sal->telephone_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->total_overtime != 0 ? number_format($sal->total_overtime, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->thr != 0 ? number_format($sal->thr, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->bonus != 0 ? number_format($sal->bonus, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->incentive != 0 ? number_format($sal->incentive, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->adjustment != 0 ? number_format($sal->adjustment, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->gross_salary != 0 ? number_format($sal->gross_salary, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->gross_salary + $sal->total_ben != 0 ? number_format($sal->gross_salary + $sal->total_ben, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->bpjs != 0 ? number_format($sal->bpjs, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->jamsostek != 0 ? number_format($sal->jamsostek, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->union != 0 ? number_format($sal->union, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->absent != 0 ? number_format($sal->absent, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->electricity != 0 ? number_format($sal->electricity, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->cooperative != 0 ? number_format($sal->cooperative, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->total_deduction != 0 ? number_format($sal->total_deduction, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->total_deduction + $sal->total_ben_ded != 0 ? number_format($sal->total_deduction + $sal->total_ben_ded, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->net_salary != 0 ? number_format($sal->net_salary, 0, ',', '.') : '-' }}
                                            </td>

                                            <td>@php
                                                $allocations = json_decode($sal->allocation);
                                                if (is_array($allocations)) {
                                                    echo implode(', ', $allocations);
                                                } else {
                                                    echo $allocations;
                                                }
                                            @endphp</td>

                                            <td class="text-end">{{ date('d M Y', strtotime($sal->date)) }}</td>
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
                    name: "All Salary Data - {{ $name->name }} - {{ $yearFilter }}.xlsx",
                });
            });
        </script>

    @endsection
