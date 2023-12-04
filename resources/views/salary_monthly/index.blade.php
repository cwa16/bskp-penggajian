@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Gaji Per Bulan</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-8">
                                <a href="{{ url('/salarymonthly/create') }}" class="btn btn-info btn-sm">Input Data</a>
                                <a href="{{ url('/salarymonthly/create') }}" class="btn btn-warning btn-sm">Edit Data</a>
                            </div>
                            <div class="col-4 justify-content-end d-flex m-auto">
                                <select class="form-select px-3 me-2">
                                    <option selected>- Filter Tahun -</option>
                                    <option value="1">2023</option>
                                    <option value="2">2024</option>
                                    <option value="3">2025</option>
                                </select>
                                <select class="form-select px-3">
                                    <option selected>- Filter Bulan -</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table
                                class="table table-sm table-striped table-hover dtTableFix5 align-items-center compact small-tbl">
                                <thead>
                                    <tr>
                                        <th rowspan="2" colspan="6" class="text-center p-0">Employee Identity</th>
                                        <th colspan="4" class="text-center p-0">Salary Components
                                        </th>
                                        <th rowspan="2" colspan="4" class="text-center p-0">
                                            Deduction</th>
                                        <th rowspan="3" class="text-center">Tanggal Pengisian</th>
                                        <th rowspan="3" class="text-center">Action</th>
                                    </tr>
                                    <tr>
                                        {{-- <th colspan="6" class="text-center p-0">Identitas Karyawan</th> --}}
                                        <th rowspan="2" class="text-center">Salary Grade
                                        </th>
                                        <th colspan="3" class="text-center p-0">Overtime
                                        </th>
                                        {{-- <th colspan="4" class="text-center bg-danger  text-white p-0">Deduction</th> --}}
                                        {{-- <th class="text-center p-0">Action</th> --}}
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Hour(ori)</th>
                                        <th>Hour(call)</th>
                                        <th>Total Overtime</th>
                                        <th>Union</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Koperasi</th>
                                        {{-- <th>Tanggal Pengisian</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>123-001</td>
                                        <td>Mr. A</td>
                                        <td>IV-A</td>
                                        <td>Monthly</td>
                                        <td>BSKP</td>
                                        <td>Assistant Manager</td>
                                        <td>8.999.999</td>
                                        <td>40</td>
                                        <td>70</td>
                                        <td>1.000.000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>500.000</td>
                                        <td>500.000</td>
                                        <td>01-12-2023</td>
                                        <td class="text-center m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>123-002</td>
                                        <td>Mr. B</td>
                                        <td>IV-A</td>
                                        <td>Monthly</td>
                                        <td>BSKP</td>
                                        <td>Administrasi</td>
                                        <td>7.999.999</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>300.000</td>
                                        <td>200.000</td>
                                        <td>01-12-2023</td>
                                        <td class="text-center m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
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
