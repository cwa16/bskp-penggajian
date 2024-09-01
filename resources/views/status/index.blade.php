@extends('layouts.main')
@section('content')
    {{-- Bagian  Isi Konten --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Status Data</h6>
                    </div>
                </div>

                <div class="card-body p-3 pb-2">
                    <button data-bs-toggle="modal" data-bs-target="#addStatus" class="btn btn-info btn-sm">Add
                        Data</button>
                    <div class="table-responsive p-0">
                        <table class="table table-small table-striped table-hover dtTable align-items-center compact">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statuses as $index => $status)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
