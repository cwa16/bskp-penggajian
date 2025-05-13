@extends('layouts.main')
@section('content')
<style>
    td, th {
        font-size: 13px;
        text-align: center;
    }
</style>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Print Salary Data</h6>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-7">
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
                                <form action="{{ url('/print-index') }}" method="GET">
                                    <div class="row">
                                        <div class="col pe-0">
                                            <select class="form-select form-select-sm" name="filter_status">
                                                <option selected disabled>-- Pilih Status --</option>
                                                <option value="All Status">All Status</option>
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status }}">{{ $status }}</option>
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
                            <form id="printForm" action="{{ route('salary.printMultiple') }}" method="POST">
                                @csrf
                                <button class="btn btn-icon btn-3 btn-primary btn-sm">
                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                    <span class="btn-inner--text">Print Selected</span>
                                </button>
                                <table class="table table-sm table-striped table-hover dtTable100 align-items-center small-tbl compact" id="example" style="font-size: 11px; text-align: center;">
                                    <thead class="bg-thead">
                                        <tr style="border: 1px solid oldlace;">
                                            <th rowspan="2" class="text-center" style="background-color: #1A73E8; color: white; border: 1px solid oldlace;">
                                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                                            </th>
                                            <th style="border: 1px solid oldlace;" colspan="7" class="text-center">Employee Identity</th>
                                            <th style="border: 1px solid oldlace;" colspan="14" class="text-center">Salary Components</th>
                                            <th style="border: 1px solid oldlace;" rowspan="2" class="text-center">Bruto Salary</th>
                                            <th style="border: 1px solid oldlace;" colspan="11" class="text-center">Deduction</th>
                                            <th style="border: 1px solid oldlace;" rowspan="2" class="text-center">Total Deduction</th>
                                            <th style="border: 1px solid oldlace;" rowspan="2" class="text-center">Nett Salary</th>
                                            <th style="border: 1px solid oldlace;" rowspan="2" class="text-center">Allocation</th>
                                            <th style="border: 1px solid oldlace;" rowspan="2" class="text-center">Date Input</th>
                                            <th style="border: 1px solid oldlace;" rowspan="2" class="text-center">Action</th>
                                        </tr>
                                        <tr style="border: 1px solid oldlace;">
                                            <th style="border: 1px solid oldlace; background-color: #1A73E8; color: white; width: 100px;">NIK</th>
                                            <th style="border: 1px solid oldlace; background-color: #1A73E8; color: white;">Name</th>
                                            <th style="border: 1px solid oldlace;">Status</th>
                                            <th style="border: 1px solid oldlace;">Dept</th>
                                            <th style="border: 1px solid oldlace;">Job</th>
                                            <th style="border: 1px solid oldlace;">Grade</th>
                                            <th style="border: 1px solid oldlace;">Acc. No</th>
                                            <th style="border: 1px solid oldlace;">Salary</th>
                                            <th style="border: 1px solid oldlace;">Ability</th>
                                            <th style="border: 1px solid oldlace;">Func. All</th>
                                            <th style="border: 1px solid oldlace;">Skill All</th>
                                            <th style="border: 1px solid oldlace;">Family All</th>
                                            <th style="border: 1px solid oldlace;">Telp. All</th>
                                            <th style="border: 1px solid oldlace;">Tran. All</th>
                                            <th style="border: 1px solid oldlace;">OT</th>
                                            <th style="border: 1px solid oldlace;">THR</th>
                                            <th style="border: 1px solid oldlace;">Bonus</th>
                                            <th style="border: 1px solid oldlace;">Incentive</th>
                                            <th style="border: 1px solid oldlace;">Sal. Backpay</th>
                                            <th style="border: 1px solid oldlace;">Adjustment</th>
                                            <th style="border: 1px solid oldlace;">Sal. Gross</th>
                                            <th style="border: 1px solid oldlace;">Pinjaman</th>
                                            <th style="border: 1px solid oldlace;">BPJS</th>
                                            <th style="border: 1px solid oldlace;">Jamsostek</th>
                                            <th style="border: 1px solid oldlace;">Union</th>
                                            <th style="border: 1px solid oldlace;">Other</th>
                                            <th style="border: 1px solid oldlace;">Absent</th>
                                            <th style="border: 1px solid oldlace;">Electricity</th>
                                            <th style="border: 1px solid oldlace;">Cooperative</th>
                                            <th style="border: 1px solid oldlace;">Internet</th>
                                            <th style="border: 1px solid oldlace;">Gas</th>
                                            <th style="border: 1px solid oldlace;">Water</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $sal)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="salary_ids[]" value="{{ $sal->salary_month_id }}" class="selectItem" onclick="togglePrintButton()">
                                                </td>
                                                <td class="text-end">{{ $sal->nik }}</td>
                                                <td><a data-bs-toggle="modal" href="#detailGaji{{ $sal->salary_month_id }}">{{ $sal->name }}</a></td>
                                                <td>{{ $sal->status }}</td>
                                                <td>{{ $sal->dept }}</td>
                                                <td>{{ $sal->jabatan }}</td>
                                                <td>{{ $sal->grade }}</td>
                                                <td>-</td>
                                                <td class="text-end">{{ number_format($sal->rate_salary, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->ability, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->fungtional_alw, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->skill_alw, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->family_alw, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->telephone_alw, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->transport_alw, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->total_overtime, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->thr, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->bonus, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->incentive, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->salary_backpay, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->adjustment, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->gross_salary, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->gross_salary, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->pinjaman, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->bpjs, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->jamsostek, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->union, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->other, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->absent, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->electricity, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->cooperative, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->internet, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->gas, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->water, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->total_deduction, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($sal->net_salary, 0, ',', '.') }}</td>
                                                <td>
                                                    @php
                                                        $allocations = json_decode($sal->allocation, true);
                                                        echo is_array($allocations) ? implode(', ', $allocations) : '-';
                                                    @endphp
                                                </td>
                                                <td class="text-end">{{ date('d M Y', strtotime($sal->salary_month_date)) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ url('/print-pdf/' . $sal->salary_month_id) }}" target="_blank">
                                                        Print
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('salary/modaldetail')

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
                                    <input type="hidden" name="token" value="{{ $jwt_token }}">
                                    <input type="hidden" name="nik" value="{{ $nik }}">
                                    <input type="hidden" name="name" value="{{ $name }}">
                                    <input type="hidden" name="jabatan" value="{{ $jabatan }}">
                                    <input type="hidden" name="dept" value="{{ $dept }}">
                                    <input type="hidden" name="role" value="{{ $role }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col px-3">
                                            <div class="row">
                                                <select name="status" id="status"
                                                    class="col form-select form-select-sm">
                                                    <option value="" selected disabled>Pilih Status</option>
                                                    <option value="Manager Staff">Manager Staff</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Contract BSKP">Contract BSKP</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <input type="month" name="month">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col">
                                            <div class="row">
                                             <input type="checkbox" name="thr" id="" value="yes" style="height: 20px; width: 20px;">
                                             <label for="">THR</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-warning btn-sm">Print</button>
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

        {{-- <div class="modal fade" id="printAllocation" tabindex="-1" role="dialog" aria-labelledby="modal-form"
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
        </div> --}}

        <div class="modal fade" id="printAllocation" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Year & Month</h5>
                            </div>
                            <div class="card-body py-3">
                                <form action="{{ url('/print-allocation') }}" method="get">
                                    @csrf
                                    <div class="row">
                                        <div class="col px-3">
                                            <div class="row">
                                                <select name="status" id="status"
                                                    class="col form-select form-select-sm">
                                                    <option value="" selected disabled>Pilih Status</option>
                                                    <option value="Manager Staff">Manager Staff</option>
                                                    <option value="Monthly">Monthly</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <input type="month" name="month">
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

        <script src="{{ asset('assets/libs/jquery/jquery.js') }}"></script>
        <script>
            function toggleSelectAll(source) {
                checkboxes = document.querySelectorAll('.selectItem');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = source.checked;
                });
                togglePrintButton();
            }

            function togglePrintButton() {
                const checkboxes = document.querySelectorAll('.selectItem:checked');
                const printButton = document.getElementById('printButton');
                printButton.disabled = checkboxes.length === 0;
            }
        </script>
        <script src="{{ asset('assets/js/tableToExcel.js') }}"></script>
        <script>
            $("#btn-d").click(function() {
                TableToExcel.convert(document.getElementById("example"), {
                    name: "Data_Gaji_May-2024.xlsx",
                });
            });
        </script>
    @endsection
