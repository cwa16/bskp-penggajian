@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Print Overtime Data</h6>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-7">
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
                                <table
                                    class="table table-sm table-striped table-hover dtTable300 align-items-center small-tbl compact"
                                    id="example">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th colspan="6" class="text-center p-0">Employee Identity</th>
                                            <th colspan="2" class="text-center p-0">Overtime Components</th>
                                            <th rowspan="2" class="text-center">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: #1A73E8;color: white;">Emp Code</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Dept</th>
                                            <th>Job</th>
                                            <th>Grade</th>
                                            <th>Overtime <br> Original</th>
                                            <th>Overtime <br> Adjustment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $sal)
                                            <tr>
                                                <td class="text-nowrap text-end">{{ $sal->nik }}</td>
                                                <td>{{ $sal->name }}
                                                </td>
                                                <td>{{ $sal->status }}</td>
                                                <td>{{ $sal->dept }}</td>
                                                <td>{{ $sal->jabatan }}</td>
                                                <td>{{ $sal->grade }}</td>

                                                <td class="text-end">
                                                    {{ $sal->total_overtime_ori != 0 ? number_format($sal->total_overtime_ori, 0, ',', '.') : '-' }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $sal->total_overtime_adj != 0 ? number_format($sal->total_overtime_adj, 0, ',', '.') : '-' }}
                                                </td>

                                                <td class="text-center m-0 p-0">
                                                    </button>
                                                    <a href="{{ url('/print-overtime-pdf/' . $sal->nik) }}"
                                                        class="btn btn-warning btn-icon-only m-0 p-0 btn-sm"
                                                        target="_blank">
                                                        <span class="btn-inner--icon"><i
                                                                class="material-icons">print</i></span>
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

        {{-- @include('salary/modaldetail') --}}

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
