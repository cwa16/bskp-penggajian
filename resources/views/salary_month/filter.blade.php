@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Input Salary Per Month</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <form action="{{ route('salary-month.create') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-auto pe-0">
                                    <select name="id_status" class="form-select form-select-sm">
                                        <option value="" {{ $statusFilter == null ? 'selected' : '' }}>
                                            - Choose Status -</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $statusFilter == $status->id ? 'selected' : '' }}>
                                                {{ $status->name_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto pe-0">
                                    <select name="year" class="form-select form-select-sm">
                                        <option value="" {{ $yearFilter == null ? 'selected' : '' }}>
                                            - Choose Year - </option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ $yearFilter == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select name="month" class="form-select form-select-sm">
                                        <option value="" {{ $monthFilter == null ? 'selected' : '' }}>
                                            - Choose Month - </option>
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ $month }}"
                                                {{ $monthFilter == $month ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                                    <a type="button" href="{{ route('salary-month') }}"
                                        class="btn btn-outline-secondary btn-sm mb-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

@endsection
