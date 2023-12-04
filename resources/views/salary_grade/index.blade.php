@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Gaji Per Grade</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-9">
                                <a href="{{ url('/salarygrade/create') }}" class="btn btn-info btn-sm">Input Data</a>
                                <a href="{{ url('/salarygrade/create') }}" class="btn btn-warning btn-sm">Edit Data</a>
                            </div>
                            {{-- <div class="col-3 justify-content-end">
                                <select class="form-select form-select-sm px-3">
                                    <option selected>- Pilih Tahun -</option>
                                    <option value="1">2023</option>
                                    <option value="2">2024</option>
                                    <option value="3">2025</option>
                                </select>
                            </div> --}}
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table table-sm align-items-center mb-0 dtTable small-tbl compact stripe">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Grade</th>
                                        {{-- <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th> --}}
                                        <th>Salary Grade</th>
                                        <th>Year</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>III-D</td>
                                        {{-- <td>Monthly</td>
                                            <td>BSKP</td>
                                            <td>Operator</td> --}}
                                        <td class="text-end">7.999.999</td>
                                        <td class="text-end">2023</td>
                                        <td class="align-middle m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                            </button>
                                            <button class="btn btn-danger btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>IV-A</td>
                                        {{-- <td>Monthly</td>
                                            <td>BSKP</td>
                                            <td>Operator</td> --}}
                                        <td class="text-end">8.999.999</td>
                                        <td class="text-end">2023</td>
                                        <td class="align-middle m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                            </button>
                                            <button class="btn btn-danger btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>V-A</td>
                                        {{-- <td>Monthly</td>
                                            <td>BSKP</td>
                                            <td>Operator</td> --}}
                                        <td class="text-end">9.999.999</td>
                                        <td class="text-end">2023</td>
                                        <td class="align-middle m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                            </button>
                                            <button class="btn btn-danger btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">delete</i></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
