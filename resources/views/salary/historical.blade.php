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
                        <div class="row">
                            {{-- <div class="col-7">
                                <button class="btn btn-icon btn-3 btn-success btn-sm" id="btn-d">
                                    <span class="btn-inner--icon"><i class="fas fa-file-excel"></i></span>
                                    <span class="btn-inner--text"> Export</span>
                                </button>
                            </div> --}}
                        </div>
                        <div class="table-responsive p-0">
                            <table
                                class="table table-sm table-striped table-hover dtTable1 align-items-center small-tbl compact"
                                id="example">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white;" rowspan="2"
                                            class="text-center" width="10px">No</th>
                                        <th colspan="5" class="text-center p-0">Employee Identity</th>
                                        <th colspan="{{ count($years) }}" class="text-center p-0">Year</th>
                                        <th rowspan="2" class="text-center p-0">Detail</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #1A73E8; color: white;">NIK</th>
                                        <th style="background-color: #1A73E8; color: white;">Name</th>
                                        <th style="background-color: #1A73E8; color: white;">Status</th>
                                        <th style="background-color: #1A73E8; color: white;">Dept</th>
                                        <th style="background-color: #1A73E8; color: white;">Job</th>
                                        @foreach ($years as $year)
                                            <th style="background-color: #1A73E8; color: white;" class="text-center">
                                                {{ $year }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $history)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $history['nik'] }}</td>
                                            <td>{{ $history['name'] }}</td>
                                            <td>{{ $history['status'] }}</td>
                                            <td>{{ $history['dept'] }}</td>
                                            <td>{{ $history['jabatan'] }}</td>
                                            @foreach ($years as $year)
                                                {{-- <td>{{ $history['grade_' . $year] }}</td> --}}
                                                <td>{{ !empty($history['grade_' . $year]) ? $history['grade_' . $year] : '-' }}
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                <a href="{{ url('/historical/' . $history['nik']) }}"
                                                    class="btn btn-success btn-icon-only m-0 p-0 btn-sm" target="_blank">
                                                    <span class="btn-inner--icon"><i class="material-icons">info</i></span>
                                                </a>
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
