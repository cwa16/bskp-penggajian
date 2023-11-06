@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Gaji</h6>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table table-sm align-items-center mb-0 dtTable">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Grade</th>
                                        <th>Dept</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=1;$i<100;$i++)
                                    <tr>
                                        <td>123-321</td>
                                        {{-- <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-2.jpg"
                                                        class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">John Michael</h6>
                                                    <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                                                </div>
                                            </div>
                                        </td> --}}
                                        {{-- <td>
                                            <p class="text-xs font-weight-bold mb-0">Manager</p>
                                            <p class="text-xs text-secondary mb-0">Organization</p>
                                        </td> --}}
                                        <td>Nama</td>
                                        <td>Nama</td>
                                        <td>Nama</td>
                                        <td>Nama</td>
                                        <td class="align-middle">
                                            Edit
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
