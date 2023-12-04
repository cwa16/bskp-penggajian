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
                            <div class="col">
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

                            </div>
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
                                    <table class="table table-sm align-items-center mb-0 text-center dtTableFix5">
                                        <thead>
                                            <tr>
                                                <th colspan="6" class="text-center p-0">Identitas Karyawan</th>
                                                <th colspan="6" class="text-center bg-success text-white p-0">Salary
                                                    Components
                                                </th>
                                                {{-- <th colspan="1" class="text-center bg-danger  text-white p-0">Deduction
                                                </th> --}}
                                            </tr>
                                            <tr>
                                                <th>NIK</th>
                                                <th>Name</th>
                                                <th>Grade</th>
                                                <th>Status</th>
                                                <th>Dept</th>
                                                <th>Job</th>
                                                <th>Salary Grade</th>
                                                <th>Ability</th>
                                                <th>Fungtional Allowance</th>
                                                <th>Family</th>
                                                <th>Adjustment</th>
                                                <th>Transport</th>
                                                {{-- <th>BPJS</th> --}}
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
                                                <td>Rp 8.999.999</td>
                                                <td><input type="text" id="row-ability" name="row-ability" value=""
                                                        placeholder="Ability"></td>
                                                <td><input type="text" id="row-fungtional" name="row-fungtional"
                                                        value="" placeholder="Fungtional Allowance"></td>
                                                <td><input type="text" id="row-family" name="row-family" value=""
                                                        placeholder="Family Allowance"></td>
                                                <td><input type="text" id="row-adjustmen" name="row-adjustmen"
                                                        value="" placeholder="Adjustmen"></td>
                                                <td><input type="text" id="row-transport" name="row-transport"
                                                        value="" placeholder="Transport Allowance"></td>
                                                {{-- <td><input type="number" id="row-bpjs" name="row-bpjs" value=""
                                                            placeholder="BPJS"></td> --}}
                                            </tr>
                                            <tr>
                                                <td>123-002</td>
                                                <td>Mr. B</td>
                                                <td>III-D</td>
                                                <td>Monthly</td>
                                                <td>BSKP</td>
                                                <td>Administrasi</td>
                                                <td>Rp 7.999.999</td>
                                                <td><input type="text" id="row-ability" name="row-ability" value=""
                                                        placeholder="Ability"></td>
                                                <td><input type="text" id="row-fungtional" name="row-fungtional"
                                                        value="" placeholder="Fungtional Allowance"></td>
                                                <td><input type="text" id="row-family" name="row-family" value=""
                                                        placeholder="Family Allowance"></td>
                                                <td><input type="text" id="row-adjustmen" name="row-adjustmen"
                                                        value="" placeholder="Adjustmen"></td>
                                                <td><input type="text" id="row-transport" name="row-transport"
                                                        value="" placeholder="Transport Allowance"></td>
                                                {{-- <td><input type="number" id="row-bpjs" name="row-bpjs" value=""
                                                            placeholder="BPJS"></td> --}}
                                            </tr>
                                            <tr>
                                                <td>123-003</td>
                                                <td>Mrs. C</td>
                                                <td>IV-A</td>
                                                <td>Monthly</td>
                                                <td>BSKP</td>
                                                <td>Administrasi</td>
                                                <td>Rp 8.999.999</td>
                                                <td><input type="text" id="row-ability" name="row-ability"
                                                        value="" placeholder="Ability"></td>
                                                <td><input type="text" id="row-fungtional" name="row-fungtional"
                                                        value="" placeholder="Fungtional Allowance"></td>
                                                <td><input type="text" id="row-family" name="row-family"
                                                        value="" placeholder="Family Allowance"></td>
                                                <td><input type="text" id="row-adjustmen" name="row-adjustmen"
                                                        value="" placeholder="Adjustmen"></td>
                                                <td><input type="text" id="row-transport" name="row-transport"
                                                        value="" placeholder="Transport Allowance"></td>
                                                {{-- <td><input type="number" id="row-bpjs" name="row-bpjs" value=""
                                                            placeholder="BPJS"></td> --}}
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
