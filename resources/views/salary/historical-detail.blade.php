@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">{{ $title }}</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div style="margin-bottom: 20px;">
                                <div class="card">
                                    <div class="card-body" width="20px">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5px">NIK</th>
                                                    <th width="1px"> : </th>
                                                    <th>{{ $biodata->nik }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <th> : </th>
                                                    <th>{{ $biodata->name }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table
                                class="table table-sm table-striped table-hover dtTable1 align-items-center small-tbl compact"
                                id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">Year</th>
                                        <th class="text-center">Dept</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $history)
                                        @foreach ($years as $year)
                                            <tr>
                                                <td class="text-center">{{ $year }}</td>
                                                <td class="text-center">{{ $biodata->dept }}</td>
                                                <td class="text-center">{{ $biodata->status }}</td>
                                                <td class="text-center">{{ $biodata->jabatan }}</td>
                                                <td class="text-center">{{ $history['grade'][$year] }}</td>
                                            </tr>
                                        @endforeach
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
