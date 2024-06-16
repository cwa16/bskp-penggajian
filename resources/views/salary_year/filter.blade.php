@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Input Salary Data Per Year</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <form action="{{ route('salary-year.create') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-auto">
                                    <select name="id_status" class="form-select form-select-sm">
                                        <option value="">- Pilih Status -</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                @if ($status->id == $selectedStatus) selected @endif>{{ $status->name_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                                    <a type="button" href="{{ route('salary-year') }}"
                                        class="btn btn-outline-secondary btn-sm mb-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
