@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Gaji Per Tahun</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-9">
                                <button type="button" class="btn btn-info">Input Data Gaji</button>
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
                            <table class="table table-sm table-striped table-hover dtTable align-items-center">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center p-0">Identitas Karyawan</th>
                                        <th colspan="6" class="text-center bg-success text-white p-0">Salary Components
                                        </th>
                                        <th colspan="4" class="text-center bg-danger  text-white p-0">Deduction</th>
                                        <th class="text-center p-0">Action</th>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Rate</th>
                                        <th>Ability</th>
                                        <th>Fungtional Allowance</th>
                                        <th>Family</th>
                                        <th>Adjustment</th>
                                        <th>Transport</th>
                                        <th>Union</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Koperasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i < 5; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>Jude</td>
                                            <td>V-A</td>
                                            <td>Monthly</td>
                                            <td>BSKP</td>
                                            <td>Operator</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td class="text-center m-0 p-0">
                                                <button class="btn btn-warning btn-icon-only m-0 p-0 btn" type="button">
                                                    <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                                </button>
                                            </td>
                                    @endfor
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
        