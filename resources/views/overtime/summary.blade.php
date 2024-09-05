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
                            <div class="col-5 justify-content-end">
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <form id="printForm" method="POST" action="">
                                @csrf
                                <table
                                    class="table table-sm table-striped table-hover dtTable2 align-items-center small-tbl compact"
                                    id="example">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th rowspan="2" class="text-center p-0">No</th>
                                            <th rowspan="2" class="text-center p-0">NIK</th>
                                            <th rowspan="2" class="text-center p-0">Name</th>
                                            <th rowspan="2" class="text-center p-0">Dept</th>
                                            <th rowspan="2" class="text-center p-0">Status</th>
                                            <th rowspan="2" class="text-center p-0">Jabatan</th>
                                            <th rowspan="2" class="text-center p-0">Batas Lembur</th>
                                            @foreach ($dates as $date)
                                                <th class="text-center p-0">{{ \Carbon\Carbon::parse($date)->format('d') }}
                                                </th>
                                            @endforeach
                                            <th rowspan="2" class="text-center p-0">Total Lembur</th>
                                            <th rowspan="2" class="text-center p-0">Adjust</th>
                                            <th colspan="2" class="text-center p-0">Total Lembur</th>
                                            <th rowspan="2" class="text-center p-0"><input type="checkbox" id="selectAll"
                                                    onclick="toggleSelectAll(this)"></th>
                                        </tr>
                                        <tr>
                                            @foreach ($dates as $date)
                                                <th class="text-center p-0">{{ \Carbon\Carbon::parse($date)->format('D') }}
                                                </th>
                                            @endforeach
                                            <th>Setelah Adjust</th>
                                            <th>Nilai Lembur (RP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $nik => $entries)
                                            @php
                                                $totalLembur = 0;
                                                $rateSalary = $entries->first()->rate_salary;
                                                $ability = $entries->first()->ability;
                                            @endphp
                                            @foreach ($entries as $entry)
                                                @php
                                                    $overtimePerDate = $entries
                                                        ->pluck('hour_call', 'overtime_date')
                                                        ->all();
                                                    $totalLembur += $entry->hour_call;
                                                @endphp
                                                <tr data-rate-salary="{{ $rateSalary }}"
                                                    data-ability="{{ $ability }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $entry->nik }}</td>
                                                    <td>{{ $entry->name }}</td>
                                                    <td>{{ $entry->dept }}</td>
                                                    <td>{{ $entry->status }}</td>
                                                    <td>{{ $entry->jabatan }}</td>
                                                    <td>-</td>

                                                    @foreach ($dates as $date)
                                                        <td class="text-center p-0">
                                                            @if (isset($overtimePerDate[$date]))
                                                                {{ $overtimePerDate[$date] }} h
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    @endforeach

                                                    <td class="total-lembur">{{ $totalLembur }} h</td>
                                                    <td>
                                                        <input type="number" class="form-control adjust-input"
                                                            value="0" min="0" step="1"
                                                            style="width: 70px;">
                                                    </td>
                                                    <td class="total-adjusted-lembur">{{ $totalLembur }} h</td>
                                                    <td class="calculated-value">Calculated</td>
                                                    <td>
                                                        <input type="checkbox" name="salary_ids[]"
                                                            value="{{ $entry->salary_years_id }}" class="selectItem"
                                                            onclick="togglePrintButton()">
                                                    </td>
                                                </tr>
                                            @endforeach
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

        <script src="{{ asset('assets/libs/jquery/jquery.js') }}"></script>
        <script>
            document.querySelectorAll('.adjust-input').forEach(input => {
                input.addEventListener('input', function() {
                    let adjustValue = parseInt(this.value) || 0;
                    let totalLemburCell = this.closest('tr').querySelector('.total-lembur');
                    let totalAdjustedLemburCell = this.closest('tr').querySelector('.total-adjusted-lembur');
                    let calculatedValueCell = this.closest('tr').querySelector('.calculated-value');

                    // Ambil total lembur dari cell
                    let totalLembur = parseInt(totalLemburCell.textContent) || 0;

                    // Hitung total lembur setelah adjust
                    let totalAdjustedLembur = totalLembur - adjustValue;

                    // Update cell total lembur setelah adjust
                    totalAdjustedLemburCell.textContent = totalAdjustedLembur + ' h';

                    // Ambil nilai rate_salary dan ability dari atribut data
                    let rateSalary = parseInt(this.closest('tr').dataset.rateSalary);
                    let ability = parseInt(this.closest('tr').dataset.ability);

                    // Kalkulasi nilai lembur setelah adjust
                    let calculatedValue = ((rateSalary + ability) / 173) * totalAdjustedLembur;

                    // Update cell calculated value
                    calculatedValueCell.textContent = calculatedValue;

                    // Update cell calculated value
                    calculatedValueCell.textContent = calculatedValue.toFixed(2);
                });
            });
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
