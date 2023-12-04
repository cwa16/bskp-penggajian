@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Input Data Gaji Per Tahun</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col">
                                <select class="form-select ps-3">
                                    <option selected>- Pilih Status -</option>
                                    <option value="Assistant trainee">Assistant trainee</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                                {{-- <div class="col">
                                    <select class="form-select ps-3">
                                        <option selected>- Pilih Departement -</option>
                                        <option value="Acc & Fin">Acc & Fin</option>
                                        <option value="BSKP">BSKP</option>
                                        <option value="Factory">Factory</option>
                                        <option value="Field">Field</option>
                                        <option value="FSD">FSD</option>
                                        <option value="HR & Legal">HR & Legal</option>
                                        <option value="HR Legal">HR Legal</option>
                                        <option value="HSE & DP">HSE & DP</option>
                                        <option value="I/A">I/A</option>
                                        <option value="I/B">I/B</option>
                                        <option value="I/C">I/C</option>
                                        <option value="II/D">II/D</option>
                                        <option value="II/E">II/E</option>
                                        <option value="II/F">II/F</option>
                                        <option value="IT">IT</option>
                                        <option value="QA">QA</option>
                                        <option value="QM">QM</option>
                                        <option value="Security">Security</option>
                                        <option value="Workshop">Workshop</option>
                                    </select>

                                </div> --}}
                            <div class="col">
                                <button type="button" class="btn btn-info">Filter</button>
                            </div>
                            <hr class="horizontal dark my-3">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-success btn-sm">Simpan</button>
                                    <a type="button" href="{{ route('salaryannual.index') }}"
                                        class="btn btn-outline-secondary btn-sm">Kembali</a>
                                </div>
                                <div class="table-responsive p-0">
                                    <table class="table table-sm align-items-center mb-0 text-center dtTableFix5 compact small-tbl">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" colspan="6" class="text-center p-0">Identitas Karyawan
                                                </th>
                                                <th colspan="2" class="text-center p-0">Salary
                                                    Components
                                                </th>
                                                <th rowspan="2" colspan="4"
                                                    class="text-center p-0">
                                                    Deduction</th>
                                                {{-- <th rowspan="3" class="text-center">Tanggal Pengisian</th> --}}
                                            </tr>
                                            <tr>
                                                {{-- <th colspan="6" class="text-center p-0">Identitas Karyawan</th> --}}
                                                <th colspan="2" class="text-center p-0">Overtime
                                                </th>
                                                {{-- <th colspan="4" class="text-center p-0">Deduction</th> --}}
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
                                                <th>Union</th>
                                                <th>Absent</th>
                                                <th>Electricity</th>
                                                <th>Koperasi</th>
                                                {{-- <th>Tanggal Pengisian</th> --}}
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
                                                <td><input type="number" id="row-hour_ori" name="row-hour_ori"
                                                        value="" placeholder="Hour(ori)"></td>
                                                <td><input type="number" id="row-hour_call" name="row-hour_call"
                                                        value="" placeholder="Hour(call)"></td>
                                                <td><input type="number" id="row-Union" name="row-Union" value=""
                                                        placeholder="Union"></td>
                                                <td><input type="number" id="row-absent" name="row-absent" value=""
                                                        placeholder="Absent"></td>
                                                <td><input type="number" id="row-electricity" name="row-electricity"
                                                        value="" placeholder="Electricity"></td>
                                                <td><input type="number" id="row-koperasi" name="row-koperasi"
                                                        value="" placeholder="Koperasi"></td>
                                            </tr>
                                            <tr>
                                                <td>123-002</td>
                                                <td>Mr. B</td>
                                                <td>III-D</td>
                                                <td>Monthly</td>
                                                <td>BSKP</td>
                                                <td>Administrasi</td>
                                                <td><input type="number" id="row-hour_ori" name="row-hour_ori"
                                                        value="" placeholder="Hour(ori)"></td>
                                                <td><input type="number" id="row-hour_call" name="row-hour_call"
                                                        value="" placeholder="Hour(call)"></td>
                                                <td><input type="number" id="row-Union" name="row-Union" value=""
                                                        placeholder="Union"></td>
                                                <td><input type="number" id="row-absent" name="row-absent"
                                                        value="" placeholder="Absent"></td>
                                                <td><input type="number" id="row-electricity" name="row-electricity"
                                                        value="" placeholder="Electricity"></td>
                                                <td><input type="number" id="row-koperasi" name="row-koperasi"
                                                        value="" placeholder="Koperasi"></td>
                                            </tr>
                                            <tr>
                                                <td>123-003</td>
                                                <td>Mrs. C</td>
                                                <td>IV-A</td>
                                                <td>Monthly</td>
                                                <td>BSKP</td>
                                                <td>Administrasi</td>
                                                <td><input type="number" id="row-hour_ori" name="row-hour_ori"
                                                        value="" placeholder="Hour(ori)"></td>
                                                <td><input type="number" id="row-hour_call" name="row-hour_call"
                                                        value="" placeholder="Hour(call)"></td>
                                                <td><input type="number" id="row-Union" name="row-Union" value=""
                                                        placeholder="Union"></td>
                                                <td><input type="number" id="row-absent" name="row-absent"
                                                        value="" placeholder="Absent"></td>
                                                <td><input type="number" id="row-electricity" name="row-electricity"
                                                        value="" placeholder="Electricity"></td>
                                                <td><input type="number" id="row-koperasi" name="row-koperasi"
                                                        value="" placeholder="Koperasi"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card my-4">
                    <div class="card-body p-3 pb-2">

                    </div>
                </div> --}}
                </div>
            </div>
        @endsection
