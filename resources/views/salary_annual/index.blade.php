@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Salary Data Per Year</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-9">
                                <a href="{{ url('/salaryannual/create') }}" class="btn btn-info btn-sm">Input Data</a>
                                <a href="{{ url('/salaryannual/edit') }}" class="btn btn-warning btn-sm">Edit Data</a>
                            </div>
                            <div class="col-3 justify-content-end">
                                <select class="form-select px-3">
                                    <option selected>- Filter Tahun -</option>
                                    <option value="1">2023</option>
                                    <option value="2">2024</option>
                                    <option value="3">2025</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table table-sm dtTableFix5 align-items-center small-tbl compact stripe hover"
                                style="font-size: 10pt; font-family: 'Arial', sans-serif;">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center p-0">Employee Identity</th>
                                        <th colspan="6" class="text-center p-0">Salary Components</th>
                                        <th colspan="2" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center">Action</th>
                                    </tr>
                                    <tr class="">
                                        <th class="cell-border">NIK</th>
                                        <th>Name</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Fungtional Allowance</th>
                                        <th>Family Allowance</th>
                                        <th>Adjustment</th>
                                        <th>Transport Allowance</th>
                                        <th>BPJS</th>
                                        <th>Jamsostek</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">123-001</td>
                                        <td>Mr. A</td>
                                        <td>IV-A</td>
                                        <td>Monthly</td>
                                        <td>BSKP</td>
                                        <td>Assistant Manager</td>
                                        <td>8.999.999</td>
                                        <td>600.000</td>
                                        <td>0</td>
                                        <td>100.000</td>
                                        <td>0</td>
                                        <td>300.000</td>
                                        <td>99.999</td>
                                        <td>199.999</td>
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
                                        <td>600.000</td>
                                        <td>0</td>
                                        <td>100.000</td>
                                        <td>0</td>
                                        <td>300.000</td>
                                        <td>89.999</td>
                                        <td>179.999</td>
                                        <td class="text-center m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>123-003</td>
                                        <td>Mrs. C</td>
                                        <td>IV-A</td>
                                        <td>Monthly</td>
                                        <td>BSKP</td>
                                        <td>Administrasi</td>
                                        <td>8.999.999</td>
                                        <td>500.000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>94.999</td>
                                        <td>189.999</td>
                                        <td class="text-center m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>123-004</td>
                                        <td>Mr. D</td>
                                        <td>IV-A</td>
                                        <td>Monthly</td>
                                        <td>HSE & DP</td>
                                        <td>Administrasi</td>
                                        <td>7.999.999</td>
                                        <td>600.000</td>
                                        <td>0</td>
                                        <td>100.000</td>
                                        <td>0</td>
                                        <td>300.000</td>
                                        <td>89.999</td>
                                        <td>179.999</td>
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
