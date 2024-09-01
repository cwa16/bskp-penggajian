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

                    <div>
                        <div>
                            <div class="card-body p-3 pb-2">
                                <table class="table table-bordered" style="width: 50px;height: 10px;">
                                    <thead>
                                        <tr>
                                            <th>Group</th>
                                            <th> : </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <th> : </th>
                                            <th>{{ \Carbon\Carbon::parse($tanggalHariIni)->format('d-m-Y') }}</th>
                                        </tr>
                                        <tr>
                                            <th>Dept</th>
                                            <th> : </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="">
                        @csrf
                        <div class="card-body p-3 pb-2">
                            @if (isset($dataGabunganGrouped) && $dataGabunganGrouped->isNotEmpty())
                                <table
                                    class="table table-sm table-striped table-hover align-items-center compact small-tbl">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">NIK</th>
                                            <th rowspan="2" class="text-center">Name</th>
                                            <th rowspan="2" class="text-center">Dept</th>
                                            <th rowspan="2" class="text-center">Status</th>
                                            <th rowspan="2" class="text-center">Jabatan</th>
                                            <th colspan="2" class="text-center">Overtime</th>
                                            <th rowspan="2" class="text-center">Approval</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Jam</th>
                                            <th class="text-center">Kalkulasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataGabunganGrouped as $status => $items)
                                            <tr>
                                                <td colspan="9" class="bg-info text-white"><strong>Status:
                                                        {{ $status }}</strong></td>
                                            </tr>
                                            @foreach ($items as $item)
                                                @php
                                                    $rate_salary = $item['user_data']['rate_salary'] ?? 0;
                                                    $ability = $item['user_data']['ability'] ?? 0;
                                                    $overtime_hour = $item['overtime_hour'] ?? 0;
                                                    $totalOvertime = (($rate_salary + $ability) / 173) * $overtime_hour;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $item['user_id'] }}</td>
                                                    <td>{{ $item['user_data']['name'] ?? 'Nama tidak ditemukan' }}</td>
                                                    <td>{{ $item['user_data']['name_dept'] ?? 'Nama tidak ditemukan' }}</td>
                                                    <td>{{ $item['user_data']['name_status'] ?? 'Nama tidak ditemukan' }}
                                                    </td>
                                                    <td>{{ $item['user_data']['name_job'] ?? 'Nama tidak ditemukan' }}</td>
                                                    <td class="text-center">
                                                        {{ $overtime_hour }}
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="hidden" name="rate_salary[{{ $loop->index }}]"
                                                            value="{{ $rate_salary }}">
                                                        <input type="hidden" name="ability[{{ $loop->index }}]"
                                                            value="{{ $ability }}">
                                                        {{ number_format($totalOvertime) }}
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="approval[{{ $item['user_id'] }}]"
                                                            value="1">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary mt-3">Submit Approval</button>
                            @else
                                <p>Tidak ada data yang cocok untuk tanggal ini.</p>
                            @endif
                        </div>

                    </form>
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const hourCallInputs = document.querySelectorAll('[name^="overtime_hour["]');

                hourCallInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        calculateTotalOvertime(this);
                    });
                });

                function calculateTotalOvertime(input) {
                    const key = input.name.match(/\[(\d+)\]/)[1];
                    const rateSalary = parseFloat(document.querySelector(`[name="rate_salary[${key}]"]`).value) || 0;
                    const ability = parseFloat(document.querySelector(`[name="ability[${key}]"]`).value) || 0;

                    const totalOvertimeInput = document.querySelector(`[name="total_overtime[${key}]"]`);

                    if (!isNaN(rateSalary) && !isNaN(ability)) {
                        const hourCall = parseFloat(input.value) || 0;
                        const totalOvertime = ((rateSalary + ability) / 173) * hourCall;
                        totalOvertimeInput.value = totalOvertime.toFixed(2);
                    } else {
                        totalOvertimeInput.value = '';
                    }
                }
            });
        </script>
    </div>
@endsection
