@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Seluruh Gaji</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col-8 mb-2">
                                <button class="btn btn-icon btn-3 btn-warning btn-sm" type="button">
                                    <span class="btn-inner--icon"><i class="material-icons">print</i></span>
                                    <span class="btn-inner--text">Print All</span>
                                </button>
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
                                class="table table-sm table-striped table-hover dtTableFix2 align-items-center small-tbl compact">
                                <thead>
                                    <tr>
                                        {{-- <th rowspan="2" class="text-center">No</th> --}}
                                        <th colspan="7" class="text-center p-0">Identitas Karyawan</th>
                                        <th colspan="11" class="text-center p-0">Salary Components</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Bruto Salary</th>
                                        <th colspan="7" class="text-center p-0">Deduction</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Total Deduction</th>
                                        <th rowspan="2" class="text-center bg-light text-dark">Nett Salary</th>
                                        <th rowspan="2" class="text-center">Tanggal Pengisian</th>
                                        <th rowspan="2" class="text-center">Check</th>
                                        <th rowspan="2" class="text-center">Approve</th>
                                        <th rowspan="2" class="text-center">Action</th>
                                    </tr>
                                    <tr>
                                        {{-- <th>No</th> --}}
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Dept</th>
                                        <th>Status</th>
                                        <th>Grade</th>
                                        <th>Job</th>
                                        <th>No Account</th>
                                        <th>Salary Grade</th>
                                        <th>Ability</th>
                                        <th>Fungtional Allowance</th>
                                        <th>Family Allowance</th>
                                        <th>Adjustment</th>
                                        <th>Transport Allowance</th>
                                        <th>Total Overtime</th>
                                        <th>THR</th>
                                        <th>Bonus</th>
                                        <th>Incentive</th>
                                        <th>Salary Gross</th>
                                        {{-- <th class=">Bruto Salary</th> --}}
                                        <th>BPJS</th>
                                        <th>Jamsostek</th>
                                        <th>Union</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Koperasi</th>
                                        <th>Sub Total Deduction</th>
                                        {{-- <th class=">Total Deduction</th> --}}
                                        {{-- <th class="bg-info text-white">Nett Salary</th> --}}
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
                                        <td>123456789</td>
                                        <td>8.999.999</td>
                                        <td>600.000</td>
                                        <td>0</td>
                                        <td>100.000</td>
                                        <td>0</td>
                                        <td>300.000</td>
                                        <td>1.000.000</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>10.999.999</td>
                                        <td class="bg-light text-dark">11.440.379</td>
                                        <td>99.999</td>
                                        <td>199.999</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>500.000</td>
                                        <td>500.000</td>
                                        <td>1.299.998</td>
                                        <td class="bg-light">1.740.378</td>
                                        <td class="bg-light text-dark">9.700.001</td>
                                        <td>01-12-2023</td>
                                        <td class="align-middle text-center text-sm"><span
                                                class="badge badge-sm bg-gradient-success"> &#10004;</td>
                                        <td class="align-middle text-center text-sm"><span
                                                class="badge badge-sm bg-gradient-secondary">&#9744;</td>
                                        <td class="text-center m-0 p-0">
                                            <button class="btn btn-primary btn-icon-only m-0 p-0 btn-sm" type="button"
                                                data-bs-toggle="modal" data-bs-target="#detailGaji">
                                                <span class="btn-inner--icon"><i class="material-icons">info</i></span>
                                            </button>
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn-sm" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">print</i></span>
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

        <div class="modal fade" id="detailGaji" tabindex="-1" role="dialog" aria-labelledby="modal-form"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-plain">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Data Status</h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('status.store') }}" method="post">
                                @csrf
                                <div class="card-body py-0">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Nama Status</label>
                                        <input type="text" class="form-control" name="name_status" required>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-sm bg-success text-white m-0">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
