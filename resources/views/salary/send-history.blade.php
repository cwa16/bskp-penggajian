@extends('layouts.main')
@section('content')
    <style>
        .sent {
            color: green;
        }

        .not-sent {
            color: red;
        }
    </style>
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
                                class="table table-sm table-striped table-hover dtTable1 align-items-center small-tbl compact"
                                id="example">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">NIK</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Name</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Dept
                                        </th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Job</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Status</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">No HP</th>
                                        <th style="background-color: #1A73E8; color: white;" class="text-center">Year</th>
                                        @foreach ($months as $month)
                                            <th style="background-color: #1A73E8; color: white;" class="text-center">
                                                {{ \Carbon\Carbon::createFromFormat('m', $month)->format('F') }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $nik => $userData)
                                        @php
                                            $user = $userData->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $user->nik }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->name_dept }}</td>
                                            <td>{{ $user->name_job }}</td>
                                            <td>{{ $user->name_status }}</td>
                                            <td>{{ $user->no_telpon }}</td>
                                            <td>{{ $user->year }}</td>
                                            @foreach ($months as $month)
                                                @php
                                                    $monthData = $userData->firstWhere('month', $month);
                                                @endphp
                                                <td class="text-center">
                                                    @if ($monthData)
                                                        @if ($monthData->is_send)
                                                            <span class="sent">✓</span>
                                                        @else
                                                            <span class="not-sent">✗</span>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endforeach
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
