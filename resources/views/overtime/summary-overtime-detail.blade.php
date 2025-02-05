@extends('layouts.main')
@section('content')
    {{-- Bagian  Isi Konten --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ $title }} - {{ $nik }} -
                            {{ $name }}</h6>
                    </div>
                </div>

                <div class="card-body p-3 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-small table-striped table-hover dtTable align-items-center compact">
                            <thead>
                                <tr>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">No</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Month</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        Limit</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        Actual</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        after Calculation</th>
                                    <th style="background-color: #1A73E8;color: white;" class="text-center">Overtime <br>
                                        from Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($overtime_records as $index => $ot)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ot->date)->format('F Y') }}</td>
                                        @if ($ot->overtime_limit == 0 || $ot->overtime_limit == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">{{ $ot->overtime_limit }} Jam</td>
                                        @endif

                                        @if ($ot->overtimeHourInDecimal == 0 || $ot->overtimeHourInDecimal == null)
                                            <td class="text-center">-</td>
                                        @else
                                            <td class="text-center">{{ number_format($ot->overtimeHourInDecimal, 2) }} Jam
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
