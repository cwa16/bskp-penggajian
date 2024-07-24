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
                                {{-- Print all tanpa filter tahun dan bulan --}}
                                {{-- <a href="{{ url('/print-all') }}" class="btn btn-icon btn-3 btn-warning btn-sm"
                                    target="_blank">
                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                    <span class="btn-inner--text">Print All</span>
                                </a> --}}
                                <button data-bs-toggle="modal" data-bs-target="#printAll"
                                    class="btn btn-icon btn-3 btn-warning btn-sm">
                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                    <span class="btn-inner--text">Print All</span>
                                </button>
                                <button data-bs-toggle="modal" data-bs-target="#printAllocation"
                                    class="btn btn-icon btn-3 btn-warning btn-sm">
                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                    <span class="btn-inner--text">Print Allocation</span>
                                </button>
                            </div>
                            <div class="col-5 justify-content-end">
                                <form action="{{ url('/salary') }}" method="GET">
                                    <div class="row">
                                        <div class="col pe-0">
                                            <select class="form-select form-select-sm" name="filter_status">
                                                <option selected disabled>-- Pilih Status --</option>
                                                    <option value="All Status">All Status</option>
                                                @foreach ($statuses_id as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name_status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col pe-0">
                                            <select class="form-select form-select-sm" name="filter_year">
                                                <option selected disabled>Select Year</option>
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
                                        <div class="col pe-0">
                                            <select class="form-select form-select-sm" name="filter_month">
                                                <option selected disabled>Select Month</option>
                                                <option value="all" {{ $selectedMonth == 'all' ? 'selected' : '' }}>
                                                    Show All Month
                                                </option>
                                                @foreach ($months as $month)
                                                    <option value="{{ $month['value'] }}"
                                                        {{ $selectedMonth == $month['value'] ? 'selected' : '' }}>
                                                        {{ $month['label'] }}
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
                            <table
                                class="table table-sm table-striped table-hover dtTable100 align-items-center small-tbl compact">
                                <thead class="bg-thead">
                                    <tr>
                                        <th colspan="7" class="text-center p-0">Employee Identity</th>
                                        <th colspan="13" class="text-center p-0">Salary Components</th>
                                        <th rowspan="2" class="text-center">Bruto Salary</th>
                                        <th colspan="7" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center">Total Deduction</th>
                                        <th rowspan="2" class="text-center">Nett Salary</th>
                                        <th rowspan="2" class="text-center">Allocation</th>
                                        <th rowspan="2" class="text-center">Date Input</th>
                                        <th rowspan="2" class="text-center">Check</th>
                                        <th rowspan="2" class="text-center">Approve</th>
                                        <th rowspan="2" class="text-center">Action</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8;color: white;">Emp Code</th>
                                        <th style="background-color: #1A73E8;color: white;">Name</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Grade</th>
                                        <th>No Account</th>

                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Fungtional All</th>
                                        <th>Skill All</th>
                                        <th>Family All</th>
                                        <th>Telephone All</th>
                                        <th>Transport All</th>
                                        <th>Total Overtime</th>
                                        <th>THR</th>
                                        <th>Bonus</th>
                                        <th>Incentive</th>
                                        <th>Adjustment</th>
                                        <th>Salary Gross</th>

                                        <th>Pinjaman</th>
                                        <th>BPJS Kesehatan</th>
                                        <th>Jamsostek</th>
                                        <th>Union</th>
                                        <th>Other</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Cooperative</th>
                                        {{-- <th>Sub Total Deduction</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $sal)
                                        <tr>
                                            <td class="text-nowrap text-end">{{ $sal->nik }}</td>
                                            <td><a data-bs-toggle="modal"
                                                    href="#detailGaji{{ $sal->id }}">{{ $sal->name }}</a>
                                            </td>
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
                                                {{ $sal->skill_alw != 0 ? number_format($sal->skill_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->family_alw != 0 ? number_format($sal->family_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->telephone_alw != 0 ? number_format($sal->telephone_alw, 0, ',', '.') : '-' }}
                                            </td>
                                            <td class="text-end">
                                                {{ $sal->transport_alw != 0 ? number_format($sal->transport_alw, 0, ',', '.') : '-' }}
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
                                                {{ $sal->pinjaman != 0 ? number_format($sal->pinjaman, 0, ',', '.') : '-' }}
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
                                                {{ $sal->other != 0 ? number_format($sal->other, 0, ',', '.') : '-' }}
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
                                            {{-- <td class="text-end">
                                                {{ $sal->total_deduction + $sal->total_ben_ded != 0 ? number_format($sal->total_deduction + $sal->total_ben_ded, 0, ',', '.') : '-' }}
                                            </td> --}}
                                            <td class="text-end">
                                                {{ $sal->net_salary != 0 ? number_format($sal->net_salary, 0, ',', '.') : '-' }}
                                            </td>

                                            {{-- <td class="text-end">{{ number_format($sal->ability, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->fungtional_alw, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->family_alw, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->transport_alw, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->skill_alw, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->telephone_alw, 0, ',', '.') }}</td>

                                            <td class="text-end">{{ number_format($sal->total_overtime, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ number_format($sal->thr, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sal->bonus, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sal->incentive, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($sal->adjustment, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ number_format($sal->gross_salary, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sal->gross_salary + $sal->total_ben, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">{{ number_format($sal->bpjs, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($sal->jamsostek, 0, ',', '.') }}</td>
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
                                                {{ number_format($sal->total_deduction + $sal->total_ben_ded, 0, ',', '.') }}
                                            </td>
                                            <td class="bg-light text-dark text-end">
                                                {{ number_format($sal->net_salary, 0, ',', '.') }}
                                            </td> --}}
                                            <td>@php
                                                $allocations = json_decode($sal->allocation);
                                                if (is_array($allocations)) {
                                                    echo implode(', ', $allocations);
                                                } else {
                                                    echo $allocations;
                                                }
                                            @endphp</td>

                                            {{-- <td class="text-end"> {{ $sal->allocation }}</td> --}}
                                            <td class="text-end">{{ date('d M Y', strtotime($sal->date)) }}</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-success"> &#10004;</td>
                                            <td class="align-middle text-center text-sm"><span
                                                    class="badge badge-sm bg-gradient-secondary">&#9744;</td>
                                            <td class="text-center m-0 p-0">
                                                <button class="btn btn-primary btn-icon-only m-0 p-0 btn-sm"
                                                    type="button" data-bs-toggle="modal"
                                                    data-bs-target="#detailGaji{{ $sal->id_month }}">
                                                    <span class="btn-inner--icon"><i
                                                            class="material-icons">info</i></span>
                                                </button>
                                                <a href="{{ url('/print-pdf/' . $sal->id_month) }}"
                                                    class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" target="_blank">
                                                    <span class="btn-inner--icon"><i
                                                            class="material-icons">print</i></span>
                                                </a>
                                                <a href="{{ url('/send-whatsapp/' . $sal->id_month) }}"
                                                    class="btn btn-success btn-icon-only m-0 p-0 btn-sm" target="_blank">
                                                    <span class="btn-inner--icon"><i
                                                            class="material-icons">mail</i></span>
                                                </a>
                                                {{-- <form action="{{ route('send-whatsapp') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="message" id="message" value="Test">
                                                    <input type="hidden" name="number_phone" id="number_phone" value="{{ $sal->salary_year->user->no_telpon }}">
                                                    <button type="submit" class="btn btn-success btn-icon-only m-0 p-0 btn-sm"><span class="btn-inner--icon"><i
                                                        class="material-icons">mail</i></span></button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" style="background-color: #1A73E8;color: white;"></td>
                                        <td class="text-end">{{ number_format($totalRateSalary, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalAbility, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalFungtionalAlw, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalSkillAlw, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalFamilyAlw, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalTelephoneAlw, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalTransportAlw, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalTotalOT, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalThr, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalBonus, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalIncentive, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalAdjustment, 0, ',', '.') }}</td>
                                        <td class="text-end">0</td>
                                        <td class="text-end">0</td>
                                        <td class="text-end">{{ number_format($totalPinjaman, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalBpjs, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalJamsostek, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalUnion, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalOther, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalAbsent, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalElectricity, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($totalCooperative, 0, ',', '.') }}</td>
                                        <td class="text-end">0</td>
                                        <td style="background-color: #1A73E8;color: white;"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('salary/modaldetail')
        {{-- Modal Print All Select Year Month --}}
        <div class="modal fade" id="printAll" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Year & Month</h5>
                            </div>
                            <div class="card-body py-2">
                                <form action="{{ url('/print-all') }}" method="get">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <label for="year" class="col pt-1">Year:</label>
                                                <select name="year" id="year"
                                                    class="col form-select form-select-sm">
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <label for="month" class="col pt-1">Month:</label>
                                                <select name="month" id="month"
                                                    class="col form-select form-select-sm">
                                                    @foreach ($months as $month)
                                                        <option value="{{ $month['value'] }}">
                                                            {{ $month['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-warning btn-sm"><span
                                                    class="btn-inner--icon"><i class="material-icons">print</i></span>
                                                <span class="btn-inner--text">Print</span></button>
                                        </div>
                                        <div class="col-auto ps-0">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-3"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Print Allocation Select Year Month --}}
        <div class="modal fade" id="printAllocation" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Year & Month</h5>
                            </div>
                            <div class="card-body py-2">
                                <form action="{{ url('/print-allocation') }}" method="get">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <label for="year" class="col pt-1">Year:</label>
                                                <select name="year" id="year"
                                                    class="col form-select form-select-sm">
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <label for="month" class="col pt-1">Month:</label>
                                                <select name="month" id="month"
                                                    class="col form-select form-select-sm">
                                                    @foreach ($months as $month)
                                                        <option value="{{ $month['value'] }}">
                                                            {{ $month['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-warning btn-sm"><span
                                                    class="btn-inner--icon"><i class="material-icons">print</i></span>
                                                <span class="btn-inner--text">Print</span></button>
                                        </div>
                                        <div class="col-auto ps-0">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-3"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
