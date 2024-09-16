@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Edit Salary Data Per Year</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <form action="{{ route('salary-year.store-new') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                    <a href="{{ route('salary-year') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive p-0">
                                        <table
                                            class="table table-sm align-items-center mb-0 dtTable small-tbl compact stripe">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th rowspan="2" class="text-center"
                                                        style="background-color: #1A73E8;color: white;">#</th>
                                                    <th colspan="6" class="text-center p-0">Employee Identity</th>
                                                    <th colspan="8" class="text-center p-0">Salary Components</th>
                                                    <th rowspan="2" class="text-center">Allocation</th>
                                                    <th rowspan="2" class="text-center">Date</th>
                                                    <th rowspan="2" class="text-center">Year</th>
                                                </tr>
                                                <tr class="">
                                                    <th style="background-color: #1A73E8;color: white;">Emp Code</th>
                                                    <th style="background-color: #1A73E8;color: white;">Name</th>
                                                    <th>Status</th>
                                                    <th>Dept</th>
                                                    <th>Job</th>
                                                    <th>Grade</th>
                                                    <th>Salary Grade</th>
                                                    <th>Ability</th>
                                                    <th>Fungtional All</th>
                                                    <th>Family All</th>
                                                    <th>Transport All</th>
                                                    <th>Skill All</th>
                                                    <th>Telephone All</th>
                                                    <th>Adjustment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($salary_years as $key => $sy)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td class="text-nowrap text-end">{{ $sy->nik }}</td>
                                                        <td>{{ $sy->name }}</td>
                                                        <td>{{ $sy->name_status }}</td>
                                                        <td>{{ $sy->name_dept }}</td>
                                                        <td>{{ $sy->name_job }}</td>

                                                        <td>
                                                            <select name="id_grade[]" id="select-data"
                                                                class="form-select form-select-sm">
                                                                @foreach ($grade as $g)
                                                                    <option value="{{ $g->id }}"
                                                                        {{ $g->name_grade == $sy->name_grade ? 'selected' : '' }}>
                                                                        {{ $g->name_grade }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td class="text-end">
                                                            <div id="data-container"></div>
                                                        </td>

                                                        <td>
                                                            {{-- INPUTAN HIDDEN --}}
                                                            <input type="hidden" name="ids[]"
                                                                value="{{ $sy->salary_years_id }}">
                                                            <input type="hidden" name="id_user[]"
                                                                value="{{ $sy->user_id }}">
                                                            <input type="hidden" name="id_salary_grade[]"
                                                                value="{{ $sy->salary_grades_id }}">
                                                            {{-- <input type="hidden" name="rate_salary[]"
                                                                value="{{ $sy->rate_salary }}"> --}}

                                                            <div class="input-group input-group-outline">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    style="width: 120px" name="ability[]"
                                                                    placeholder="Enter the ability"
                                                                    value="{{ $sy->ability != 0 ? $sy->ability : '' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    style="width: 120px" name="fungtional_alw[]"
                                                                    placeholder="Enter the fungtional allowance"
                                                                    value="{{ $sy->fungtional_alw != 0 ? $sy->fungtional_alw : '' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    style="width: 120px" name="family_alw[]"
                                                                    placeholder="Enter the family allowance"
                                                                    value="{{ $sy->family_alw != 0 ? $sy->family_alw : '' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    style="width: 120px" name="transport_alw[]"
                                                                    placeholder="Enter the transport allowance"
                                                                    value="{{ $sy->transport_alw != 0 ? $sy->transport_alw : '' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    style="width: 120px" name="skill_alw[]"
                                                                    placeholder="Enter the skill allowance"
                                                                    value="{{ $sy->skill_alw != 0 ? $sy->skill_alw : '' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    style="width: 120px" name="telephone_alw[]"
                                                                    placeholder="Enter the telephone allowance"
                                                                    value="{{ $sy->telephone_alw != 0 ? $sy->telephone_alw : '' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="number" class="form-control form-control-sm"
                                                                    style="width: 120px" name="adjustment[]"
                                                                    placeholder="Enter the adjustment"
                                                                    value="{{ $sy->adjustment != 0 ? $sy->adjustment : '' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <select class="form-select form-select-sm allocation"
                                                                    name="allocation[]"
                                                                    style="min-height: 20px;width: 100% !important;padding: 0 0 0 0;"
                                                                    data-placeholder="Select allocation"
                                                                    multiple="multiple">
                                                                    @php
                                                                        $selectedAllocations =
                                                                            json_decode($sy->allocation, true) ?? [];
                                                                    @endphp

                                                                    <option value="A"
                                                                        {{ in_array('A', $selectedAllocations) ? 'selected' : '' }}>
                                                                        A</option>
                                                                    <option value="B"
                                                                        {{ in_array('B', $selectedAllocations) ? 'selected' : '' }}>
                                                                        B</option>
                                                                    <option value="C"
                                                                        {{ in_array('C', $selectedAllocations) ? 'selected' : '' }}>
                                                                        C</option>
                                                                    <option value="D"
                                                                        {{ in_array('D', $selectedAllocations) ? 'selected' : '' }}>
                                                                        D</option>
                                                                    <option value="E"
                                                                        {{ in_array('E', $selectedAllocations) ? 'selected' : '' }}>
                                                                        E</option>
                                                                    <option value="F"
                                                                        {{ in_array('F', $selectedAllocations) ? 'selected' : '' }}>
                                                                        F</option>
                                                                    <option value="Factory"
                                                                        {{ in_array('Factory', $selectedAllocations) ? 'selected' : '' }}>
                                                                        Factory</option>
                                                                    <option value="GAE"
                                                                        {{ in_array('GAE', $selectedAllocations) ? 'selected' : '' }}>
                                                                        GAE</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="date" name="date"
                                                                id="" value="{{ $sy->date ?? '' }}">
                                                        </td>
                                                        <td class="text-end">
                                                            {{ $sy->year }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/jquery.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Handle checkbox select all
            $('#data-container').on('change', '#checkboxAll', function() {
                $('.checkboxItem').prop('checked', $(this).prop('checked'));
            });

            // Handle select change event
            $('#select-data').change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: "{{ route('salary-year.get-rate-salary') }}",
                    type: "GET",
                    data: {
                        id_grade: selectedValue
                    },
                    dataType: "json",
                    success: function(data) {
                        var content = '';

                        function numberFormat(number) {
                            return new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(number);
                        }

                        $.each(data, function(index, item) {
                            content += `
                                <tr>
                                    <td>
                                        <input type="hidden" name="id_salary_grade[]" value="${item.id}">
                                        <input type="hidden" name="rate_salary[]" value="${item.rate_salary}">
                                        ${numberFormat(item.rate_salary)}
                                    </td>
                                </tr>
                            `;
                        });

                        $('#data-container').html(content);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ', error);
                    }
                });
            });
        });
    </script>
@endsection
