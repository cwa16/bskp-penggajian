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
                            <div class="col-8">
                                <button type="button" class="btn btn-info">Input Data Gaji</button>
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
                            <table class="table table-sm table-striped table-hover dtTable align-items-center">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">No</th>
                                        <th rowspan="2" class="text-center">Tanggal Pengisian</th>
                                        <th colspan="11" class="text-center p-0">Identitas Karyawan</th>
                                        <th colspan="11" class="text-center bg-success text-white p-0 border">Salary
                                            Components
                                        </th>
                                        <th colspan="5" class="text-center bg-success text-white p-0 border">Benefite
                                        </th>
                                        <th rowspan="2" class="text-center bg-success text-white border">Bruto Salary
                                        </th>
                                        <th colspan="7" class="text-center bg-danger text-white p-0 border">
                                            Deduction</th>
                                        <th colspan="5" class="text-center bg-danger text-white p-0 border">
                                            Deduction Benefite</th>
                                        <th rowspan="2" class="text-center bg-danger text-white border">Total Deduction
                                        </th>
                                        <th rowspan="2" class="text-center bg-secondary text-white border">Nett
                                            Salary
                                        </th>
                                        <th rowspan="2" class="text-center text-nowrap border">Action</th>
                                    </tr>
                                    <tr>
                                        {{-- <th>No</th> --}}
                                        {{-- <th>Tanggal Pengisian</th> --}}
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Dept</th>
                                        <th>Status</th>
                                        <th>Grade</th>
                                        <th>Job</th>
                                        <th>Date of Birth</th>
                                        <th>Date of Join</th>
                                        <th>Marital Status</th>
                                        <th>Tax ID Number</th>
                                        <th>No Account</th>
                                        <th>Rate</th>
                                        <th>Ability</th>
                                        <th>Fungtional Allowance</th>
                                        <th>Family Allowance</th>
                                        <th>Adjustment</th>
                                        <th>Transport Allowance</th>
                                        <th>Total Overtime</th>
                                        <th>THR</th>
                                        <th>Bonus</th>
                                        <th>Incentive</th>
                                        <th class="bg-light text-dark">Salary Gross</th>
                                        <th>Jamsostek JKK</th>
                                        <th>Jamsostek TK</th>
                                        <th>Jamsostek THT</th>
                                        <th>PPh 21</th>
                                        <th class="bg-light text-dark">Sub Total Benefite</th>
                                        {{-- <th class="bg-light">Bruto Salary</th> --}}
                                        <th>BPJS</th>
                                        <th>Jamsostek</th>
                                        <th>Union</th>
                                        <th>Absent</th>
                                        <th>Electricity</th>
                                        <th>Koperasi</th>
                                        <th class="bg-light text-dark">Sub Total Deduction</th>
                                        <th>Jamsostek JKK</th>
                                        <th>Jamsostek TK</th>
                                        <th>Jamsostek THT</th>
                                        <th>PPh 21</th>
                                        <th class="bg-light text-dark">Sub Total Deduction Benefite</th>
                                        {{-- <th class="bg-light">Total Deduction</th> --}}
                                        {{-- <th class="bg-info text-white">Nett Salary</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i < 5; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>01-01-2024</td>
                                            <td>123-321</td>
                                            <td>Messi</td>
                                            <td>BSKP</td>
                                            <td>Monthly</td>
                                            <td>V-A</td>
                                            <td>Asisstent Manager</td>
                                            <td>12-12-1999</td>
                                            <td>01-01-2011</td>
                                            <td>K3</td>
                                            <td>987654321</td>
                                            <td>123456789</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td></td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td class="bg-light text-dark">Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td class="bg-light text-dark">Rp 9.999.999</td>
                                            <td class="bg-light">Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td class="bg-light text-dark">Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td>Rp 9.999.999</td>
                                            <td class="bg-light text-dark">Rp 9.999.999</td>
                                            <td class="bg-light">Rp 9.999.999</td>
                                            <td class="bg-secondary text-white">Rp 9.999.999</td>
                                            <td class="text-center m-0 p-0">
                                                <button class="btn btn-warning btn-icon-only m-0 p-0 btn" type="button">
                                                    <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endfor
                                    <tr>
                                        <td>5</td>
                                        <td>01-01-2024</td>
                                        <td>123-321</td>
                                        <td>Ronaldo</td>
                                        <td>Acc & Fin</td>
                                        <td>Staff</td>
                                        <td>V-A</td>
                                        <td>Asisstent Manager</td>
                                        <td>12-12-1999</td>
                                        <td>01-01-2011</td>
                                        <td>K3</td>
                                        <td>987654321</td>
                                        <td>123456789</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td></td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td class="bg-light">Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td class="bg-light">Rp 9.999.999</td>
                                        <td class="bg-secondary text-white">Rp 9.999.999</td>
                                        <td class="text-center m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn" type="button">
                                                <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>01-01-2024</td>
                                        <td>123-321</td>
                                        <td>Benzema</td>
                                        <td>BSKP</td>
                                        <td>Staff</td>
                                        <td>V-A</td>
                                        <td>Asisstent Manager</td>
                                        <td>12-12-1999</td>
                                        <td>01-01-2011</td>
                                        <td>K3</td>
                                        <td>987654321</td>
                                        <td>123456789</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td></td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td class="bg-light">Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td>Rp 9.999.999</td>
                                        <td class="bg-light text-dark">Rp 9.999.999</td>
                                        <td class="bg-light">Rp 9.999.999</td>
                                        <td class="bg-secondary text-white">Rp 9.999.999</td>
                                        <td class="text-center m-0 p-0">
                                            <button class="btn btn-warning btn-icon-only m-0 p-0 btn" type="button">
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
