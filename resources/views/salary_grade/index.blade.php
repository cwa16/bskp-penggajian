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
                                <button type="button" class="btn btn-info">+ Tambah Data</button>
                            </div>
                            <div class="col-3 justify-content-end">
                                <select class="form-select px-3">
                                    <option selected>- Pilih Tahun -</option>
                                    <option value="1">2023</option>
                                    <option value="2">2024</option>
                                    <option value="3">2025</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table table-sm align-items-center mb-0 dtTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th>
                                        <th>Grade_Sal</th>
                                        <th>Year</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i < 5; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>V-A</td>
                                            <td>Monthly</td>
                                            <td>BSKP</td>
                                            <td>Operator</td>
                                            <td>Rp 9.999.999</td>
                                            <td>2027</td>
                                            <td class="align-middle">
                                                <button class="btn btn-warning btn-icon-only p-0" type="button">
                                                    <span class="btn-inner--icon"><i class="material-icons">edit</i></span>
                                                </button>
                                                <button class="btn btn-danger btn-icon-only  p-0" type="button">
                                                    <span class="btn-inner--icon"><i
                                                            class="material-icons">delete</i></span>
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
